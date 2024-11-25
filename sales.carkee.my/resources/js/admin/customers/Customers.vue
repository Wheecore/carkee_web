<template>
  <div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4">
                        Customers
                        <div class="form-group d-inline-flex float-right mr-1">
                            <input type="text" class="form-control" placeholder="Search" v-model="search" @input="fetchCustomers(pagination.current_page)" />
                        </div>
                    </h4>
					<table class="table" id="myDataTable">
						<thead>
						<tr>
							<th>Staff</th>
							<th>Customer Code</th>
							<th>Name</th>
							<th>Company Number</th>
							<th>Company Phone</th>
							<th>PIC Name</th>
							<th>PIC Phone</th>
							<th>Address</th>
							<th>Options</th>
						</tr>
						</thead>
						<tbody>
						<tr v-for="user in users" :key="user.id">
							<td>{{ user.staff }}</td>
							<td>{{ user.code }}</td>
							<td>{{ user.name }}</td>
							<td>{{ user.company_number ?? '-' }}</td>
							<td>{{ user.company_phone ??'-' }}</td>
							<td>{{ user.pic_name ??'-' }}</td>
							<td>{{ user.pic_phone ??'-' }}</td>
							<td>{{ user.address }}</td>
							<td>
								<router-link :to="'/customers/' + encryptId(user.id) + ''" class="btn btn-sm btn-primary mr-1">View</router-link>
								<router-link :to="'/customers/' + encryptId(user.id) + '/edit'" class="btn btn-sm btn-primary mr-1">Edit</router-link>
								<button @click="deleteCustomer" :data-id="user.id" class="btn btn-sm btn-danger btn-delete mr-1" data-bs-toggle="modal" data-bs-target="#delete">Delete</button>
							</td>
						</tr>
						</tbody>
					</table>
                    <div class="mb-3">Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} records - Page {{ pagination.current_page }} of {{ pagination.last_page }}</div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                                <a class="page-link" @click.prevent="fetchCustomers(pagination.current_page - 1)" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item" v-for="page in pagination.last_page" :key="page" :class="{ active: page === pagination.current_page }">
                                <a class="page-link" @click.prevent="fetchCustomers(page)" href="#">{{ page }}</a>
                            </li>
                            <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                                <a class="page-link" @click.prevent="fetchCustomers(pagination.current_page + 1)" href="#" aria-label="Next">
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
                    <button @click="confirmDeleteCustomer" type="button" class="btn btn-primary">Submit</button>
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
            users: [],
            pagination: {},
            search: '',
            delete_id: ''
        }
    },
    methods: {
        encryptId,
        async fetchCustomers(page = 1) {
            await axios.post(`/api/get-customers?page=${page}&search=${this.search}`)
            .then(response => {
                this.users = response.data.data;
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
        deleteCustomer(e)
        {
            this.delete_id = e.target.dataset.id;
        },
        async confirmDeleteCustomer() {
            await axios.post('/api/customers/delete', {
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
        },
    },
    mounted() {
        document.title = 'Customers';
        this.fetchCustomers();
    },
};
</script>
