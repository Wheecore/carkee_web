<template>
    <div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="text-right">
                    <button class="btn btn-md btn-primary" @click="syncProducts">Sync Products</button>
                </div>
                <hr>
                <div class="mb-3 card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-4">
                            Inventory
                            <div class="form-group d-inline-flex float-right mr-1">
                                <input type="text" class="form-control" placeholder="Search" v-model="search" @input="fetchProducts(pagination.current_page)" />
                            </div>
                        </h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products" :key="product.id" :id="product.id">
                                    <td>{{ product.name }}</td>
                                    <td>{{ product.stock }}</td>
                                    <td>RM {{ product.amount }}</td>
                                    <td>{{ product.disc }}%</td>
                                    <td>
                                        <button @click="updateProduct" :data-id="product.id" :data-name="product.name" :data-stock="product.stock" :data-amount="product.amount" :data-disc="product.disc" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#update">Update</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mb-3">Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} records - Page {{ pagination.current_page }} of {{ pagination.last_page }}</div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                    <a class="page-link" @click.prevent="fetchProducts(pagination.current_page - 1)" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item" v-for="page in pagination.last_page" :key="page" :class="{ active: page === pagination.current_page }">
                                    <a class="page-link" @click.prevent="fetchProducts(page)" href="#">{{ page }}</a>
                                </li>
                                <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                    <a class="page-link" @click.prevent="fetchProducts(pagination.current_page + 1)" href="#" aria-label="Next">
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Product</label>
                            <span class="text-danger"> *</span>
                            <input type="text" class="form-control" v-model="product.name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Stock</label>
                            <span class="text-danger"> *</span>
                            <input type="number" class="form-control" v-model="product.stock" required />
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Amount</label>
                            <span class="text-danger"> * (per item)</span>
                            <input type="number" step="0.01" class="form-control" v-model="product.amount" required />
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Discount %</label>
                            <span class="text-danger"> *</span>
                            <input type="number" step="0.01" class="form-control" v-model="product.disc" required />
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button @click="updateProductSubmit" type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import { authLogout } from '../services/auth';
    export default {
        data() {
            return {
                products: [],
                product: '',
                pagination: {},
                search: '',
            };
        },
        methods: {
            async fetchProducts(page = 1) {
                await axios.post(`/api/admin/get-products?page=${page}&search=${this.search}`)
                .then(response => {
                    this.products = response.data.data;
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
            async syncProducts() {
                Swal.fire({
                    title: "Syncing",
                    text: "Please wait the products are syncing",
                    icon: "warning",
                });
                await axios.post('/api/admin/sync-products')
                .then(response => {
                    this.$nextTick(() => {
                        Swal.fire({
                            title: "Success",
                            text: response.data.message,
                            icon: "success",
                        }).then((result) => {
                            this.fetchProducts();
                        });
                    });
                })
                .catch(error => {
                    console.error("There was an error!", error);
                });
            },
            updateProduct(e)
            {
                this.product = {
                    'id': e.target.dataset.id,
                    'name': e.target.dataset.name,
                    'stock': e.target.dataset.stock,
                    'amount': e.target.dataset.amount,
                    'disc': e.target.dataset.disc,
                };
            },
            async updateProductSubmit()
            {
                await axios.post('/api/admin/update-product', {
                    product: this.product
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
            },
        },
        mounted() {
            document.title = 'Inventory';
            this.fetchProducts();
        },
    }
</script>
