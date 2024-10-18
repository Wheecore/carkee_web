<template>
    <div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="mb-3 card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-4">
                            My Profile
                            <button class="btn btn-sm btn-primary float-right mr-1" data-bs-toggle="modal" data-bs-target="#edit-profile">Edit Profile</button>
                            <button class="btn btn-sm btn-primary float-right mr-1" data-bs-toggle="modal" data-bs-target="#change-password">Change Password</button>
                        </h4>
                        <div class="list-group">
                            <span class="list-group-item border-0">Name: {{ user.name }}</span>
                            <span class="list-group-item border-0">Email: {{ user.email }}</span>
                            <span class="list-group-item border-0">Role: <span v-if="user.role == 1">Admin</span> <span v-else>User</span></span>
                            <span class="list-group-item border-0">Created: {{ user.created_at }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit-profile" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="updateProfile">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="">Name</label>
                                <span class="text-danger"> *</span>
                                <input type="text" :class="['form-control', {'is-invalid': name_error}]" name="name" v-model="user.name">
                                <span class="invalid-feedback" v-if="name_error" role="alert">
                                    <strong>{{ name_error }}</strong>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="">Email</label>
                                <span class="text-danger"> *</span>
                                <input type="email" :class="['form-control', {'is-invalid': email_error}]" name="email" v-model="user.email">
                                <span class="invalid-feedback" v-if="email_error" role="alert">
                                    <strong>{{ email_error }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="change-password" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form @submit.prevent="changePassword">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="">Previous Password</label>
                                <span class="text-danger"> *</span>
                                <input type="password" :class="['form-control', {'is-invalid': old_password_error}]" name="old_password" v-model="old_password">
                                <span class="invalid-feedback" v-if="old_password_error" role="alert">
                                    <strong>{{ old_password_error }}</strong>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="">New Password</label>
                                <span class="text-danger"> *</span>
                                <input type="password" :class="['form-control', {'is-invalid': password_error}]" name="password" v-model="password">
                                <span class="invalid-feedback" v-if="password_error" role="alert">
                                    <strong>{{ password_error }}</strong>
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="">Confirm Password</label>
                                <span class="text-danger"> *</span>
                                <input type="password" :class="['form-control', {'is-invalid': password_confirmation_error}]" name="password_confirmation" v-model="password_confirmation">
                                <span class="invalid-feedback" v-if="password_confirmation_error" role="alert">
                                    <strong>{{ password_confirmation_error }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
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
                id: localStorage.getItem('id'),
                user: '',
                old_password: "",
                password: "",
                password_confirmation: "",
                name_error: '',
                email_error: '',
                old_password_error: '',
                password_error: '',
                password_confirmation_error: '',
            };
        },
        methods: {
            async updateProfile() {
                this.name_error = '',
                this.email_error = '',
                await axios.post('/api/update-profile', {
                    id: this.id,
                    name: this.user.name,
                    email: this.user.email,
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
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        for (const field in validationErrors) {
                            if (this[`${field}_error`] !== undefined) {
                                this[`${field}_error`] = validationErrors[field][0];
                            }
                        }
                    } else {
                        console.error("There was an error!", error);
                    }
                });
            },
            async changePassword() {
                this.old_password_error = '',
                this.password_error = '',
                this.password_confirmation_error = '',
                await axios.post('/api/change-password', {
                    id: this.id,
                    old_password: this.old_password,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
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
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors;
                        for (const field in validationErrors) {
                            if (this[`${field}_error`] !== undefined) {
                                this[`${field}_error`] = validationErrors[field][0];
                            }
                        }
                    } else {
                        console.error("There was an error!", error);
                    }
                });
            },
            async fetchUserDetails() {
                await axios.post('/api/admin/users/show', {
                    id: this.id,
                })
                .then(response => {
                    this.user = response.data.user;
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
        },
        mounted() {
            document.title = 'My Profile';
            this.fetchUserDetails();
        },
    }
</script>
