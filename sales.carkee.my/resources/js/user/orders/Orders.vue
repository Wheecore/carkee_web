<template>
  <div>
    <div class="row">
        <div class="col-lg-12">
            <div class="text-right">
                <router-link to="/orders/create" class="btn btn-md btn-primary">Add New Order</router-link>
            </div>
            <hr>
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4">
                        Orders
                        <div class="form-group d-inline-flex float-right mr-1">
                            <input type="text" class="form-control" placeholder="Search" v-model="search" @input="fetchOrders(pagination.current_page)" />
                        </div>
                    </h4>
                    <table class="table" id="data-tbl" style="width:100%">
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
                                    <router-link :to="'/orders/' + encryptId(order.id) + ''" class="btn btn-sm btn-primary mr-1">View</router-link>
                                    <a :href="'/pdf/' + order.id + '/invoice'" target="_blank" class="btn btn-sm btn-primary mr-1">
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
  </div>
</template>

<script>
import { encryptId } from '../../services/cryptoUtils';
import { authLogout } from '../../services/auth';

export default {
    data() {
        return {
            orders: [],
            pagination: {},
            search: '',
        }
    },
    methods: {
        encryptId,
        async fetchOrders(page = 1) {
            await axios.post(`/api/get-orders?page=${page}&search=${this.search}`, {
                id: localStorage.getItem('id')
            })
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
        }
    },
    mounted() {
        document.title = 'Orders';
        this.fetchOrders();
    },
};
</script>
