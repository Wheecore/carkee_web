<template>
  <div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4">
                        Orders
                        <div class="form-group d-inline-flex float-right mr-1">
                            <input type="text" class="form-control" placeholder="Search" v-model="search" @input="fetchOrders(pagination.current_page)" />
                        </div>
                    </h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Payment Terms</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders" :key="order.id">
                                <td>{{ order.code }}</td>
                                <td>{{ order.name }}</td>
                                <td>{{ order.phone }}</td>
                                <td>{{ order.payment_term }}</td>
                                <td>{{ order.payment_due_date }}</td>
                                <td>RM {{ order.total }}</td>
                                <td>{{ order.created_at }}</td>
                                <td>
                                    <span class="badge badge-warning" v-if="order.status == 0">Pending</span>
                                    <span class="badge badge-success" v-else>Completed</span>
                                </td>
                                <td>
                                    <router-link :to="'/admin/orders/' + encryptId(order.id) + ''" class="btn btn-sm btn-primary mr-1">View</router-link>
                                    <router-link :to="'/admin/orders/' + encryptId(order.id) + '/edit'" class="btn btn-sm btn-primary mr-1">Edit</router-link>
                                    <a :href="'/pdf/' + order.id + '/invoice'" target="_blank" :data-id="order.id" class="btn btn-sm btn-primary mr-1">
                                        Invoice
                                    </a>
                                    <a :href="'/pdf/' + order.id + '/delivery'" target="_blank" class="btn btn-sm btn-primary mr-1">
                                        Delivery Order
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mb-3">Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} records - Page {{ pagination.current_page }} of {{ pagination.last_page }}</div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                <a class="page-link" @click.prevent="fetchOrders(pagination.current_page - 1)" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item" v-for="page in pagination.last_page" :key="page" :class="{ active: page === pagination.current_page }">
                                <a class="page-link" @click.prevent="fetchOrders(page)" href="#">{{ page }}</a>
                            </li>
                            <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                <a class="page-link" @click.prevent="fetchOrders(pagination.current_page + 1)" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you would like to delete?
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button @click="confirmDeleteOrder" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>
<script>
import { encryptId } from '../../services/cryptoUtils';
import { authLogout } from '../../services/auth';
import Swal from "sweetalert2";

export default {
    data() {
        return {
            orders: [],
            pagination: {},
            search: '',
            delete_id: '',
        }
    },
    methods: {
        encryptId,
        async fetchOrders(page = 1) {
            await axios.post(`/api/admin/get-orders?page=${page}&search=${this.search}`)
            .then(response => {
                this.orders = response.data.data;
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
        deleteOrder(e)
        {
            this.delete_id = e.target.dataset.id;
        },
        async confirmDeleteOrder() {
            await axios.post('/api/orders/delete', {
                id: this.delete_id
            })
            .then(response => {
                Swal.fire({
                    title: "Success",
                    text: response.data.message,
                    icon: "success",
                }).then((result) => {
                    location.reload();
                });
            })
            .catch(error => {
                console.error("There was an error!", error);
            });
        }
    },
    mounted() {
        document.title = 'Orders';
        this.fetchOrders();
    },
};
</script>
