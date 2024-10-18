<template>
    <div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="mb-3 card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-4">
                            Credit Notes
                            <div class="form-group d-inline-flex float-right mr-1">
                                <input type="text" class="form-control" placeholder="Search" v-model="search" @input="fetchCreditNotes(pagination.current_page)" />
                            </div>
                        </h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Order Code</th>
                                    <th>Due</th>
                                    <th>Paid</th>
                                    <th>Days Remaining</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="note in notes" :key="note.id" :id="note.id">
                                    <td>{{ note.name }}</td>
                                    <td>{{ note.code }}</td>
                                    <td>
                                        <span v-if="note.due > 0">RM {{ note.due }}</span>
                                        <span v-else>RM {{ note.amount }}</span>
                                    </td>
                                    <td>RM {{ note.paid }}</td>
                                    <td>
                                        <span v-if="note.due > 0">
                                            <span v-if="note.days_remaining > 0">{{ note.days_remaining }} days</span>
                                            <span v-else class="badge badge-danger">Due</span>
                                        </span>
                                        <span v-else>-</span>
                                    </td>
                                    <td>
                                        <button v-if="note.due > 0" @click="updateCreditNote" :data-id="note.id" :data-name="note.name" :data-due="note.due" class="btn btn-sm btn-outline-primary mr-1" data-bs-toggle="modal" data-bs-target="#update">Make Transaction</button>
                                        <button @click="getTransactionHistory" :data-id="note.id" class="btn btn-sm btn-outline-primary mr-1" data-bs-toggle="modal" data-bs-target="#history">Transaction History</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mb-3">Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} records - Page {{ pagination.current_page }} of {{ pagination.last_page }}</div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                    <a class="page-link" @click.prevent="fetchCreditNotes(pagination.current_page - 1)" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item" v-for="page in pagination.last_page" :key="page" :class="{ active: page === pagination.current_page }">
                                    <a class="page-link" @click.prevent="fetchCreditNotes(page)" href="#">{{ page }}</a>
                                </li>
                                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                    <a class="page-link" @click.prevent="fetchCreditNotes(pagination.current_page + 1)" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Credit Note</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Customer</label>
                            <span class="text-danger"> *</span>
                            <input type="text" class="form-control" v-model="customer.name" disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Payment Due</label>
                            <span class="text-danger"> *</span>
                            <input type="number" class="form-control" v-model="customer.due" disabled />
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Amount</label>
                            <span class="text-danger"> *</span>
                            <input type="number" step="0.01" class="form-control" v-model="customer.amount" min="1" :max="customer.due" required />
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button @click="makeTransaction" type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="history" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction History</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(row, index) in transactions" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ row.code }}</td>
                                        <td>RM {{ row.amount }}</td>
                                        <td>{{ row.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { authLogout } from '../services/auth';
import Swal from "sweetalert2";
    export default {
        data() {
            return {
                notes: [],
                transactions: [],
                customer: '',
                pagination: {},
                search: '',
            };
        },
        methods: {
            async fetchCreditNotes(page = 1) {
                await axios.post(`/api/admin/credit-notes?page=${page}&search=${this.search}`)
                .then(response => {
                    this.notes = response.data.data;
                    this.pagination = response.data;
                })
                .catch(error => {
                    if (error.response && error.response.status === 401) {
                        Swal.fire({
                            title: "Warning",
                            text: 'Session expired! Login again.',
                            icon: "warning",
                        }).then((result) => {
                            authLogout();
                        });
                    } else {
                        console.error("There was an error!", error);
                    }
                });
            },
            updateCreditNote(e)
            {
                this.customer = {
                    'id': e.target.dataset.id,
                    'name': e.target.dataset.name,
                    'due': e.target.dataset.due,
                    'amount': 0,
                };
            },
            async getTransactionHistory(e) {
                await axios.post('/api/admin/credit-notes/transaction-histrory', {
                    id: e.target.dataset.id
                })
                .then(response => {
                    this.transactions = response.data;
                })
                .catch(error => {
                    console.error("There was an error!", error);
                });
            },
            async makeTransaction()
            {
                await axios.post('/api/admin/credit-notes/update', {
                    id: this.customer.id,
                    amount: this.customer.amount,
                })
                .then(response => {
                    if (response.data.status) {
                        Swal.fire({
                            title: "Success",
                            text: response.data.message,
                            icon: "success",
                        }).then((result) => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Warning",
                            text: response.data.message,
                            icon: "warning",
                        }).then((result) => {
                            location.reload();
                        });
                    }
                })
                .catch(error => {
                    console.error("There was an error!", error);
                });
            },
        },
        mounted() {
            document.title = 'Credit Notes';
            this.fetchCreditNotes();
        },
    }
</script>
