<template>
  <div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4">Edit Staff</h4>
                    <form @submit.prevent="editUserDetails">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Name</label>
                                    <span class="text-danger"> *</span>
                                    <input type="text" :class="['form-control', {'is-invalid': name_error}]" name="name" v-model="name">
                                    <span class="invalid-feedback" v-if="name_error" role="alert">
                                        <strong>{{ name_error }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Email</label>
                                    <span class="text-danger"> *</span>
                                    <input type="email" :class="['form-control', {'is-invalid': email_error}]" name="email" v-model="email">
                                    <span class="invalid-feedback" v-if="email_error" role="alert">
                                        <strong>{{ email_error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Status</label>
                                    <span class="text-danger"> *</span>
                                    <select :class="['form-control', {'is-invalid': status_error}]" v-model="status" name="status">
                                        <option value="">Choose...</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive
                                        </option>
                                    </select>
                                    <span class="invalid-feedback" v-if="status_error" role="alert">
                                        <strong>{{ status_error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-md btn-primary" type="submit">
                                        Submit
                                        <div class="spinner-border d-none" role="status"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>
<script>
import Swal from "sweetalert2";
import { decryptId } from '../../services/cryptoUtils';
export default {
    data() {
        return {
            id: '',
            name: '',
            email: '',
            status: '',
            name_error: '',
            email_error: '',
            status_error: '',
        }
    },
    methods: {
        decryptId,
        async fetchUserDetails() {
            await axios.post('/api/admin/users/show', {
                id: this.id,
            })
            .then(response => {
                const user = response.data.user;
                this.name = user.name;
                this.email = user.email;
                this.status = user.status;
            })
            .catch(error => {
                console.error("There was an error!", error);
            });
        },
        async editUserDetails(e) {
            this.name_error = '';
            this.email_error = '';
            this.status_error = '';
            e.target.disabled = true;
            document.querySelector('.spinner-border').classList.remove('d-none');
            await axios.post('/api/admin/users/update', {
                id: this.id,
                name: this.name,
                email: this.email,
                status: this.status,
            })
            .then(response => {
                e.target.disabled = false;
                document.querySelector('.spinner-border').classList.add('d-none');
                Swal.fire({
                    title: "Success",
                    text: response.data.message,
                    icon: "success",
                }).then((result) => {
                    this.$router.push("/admin/users");               
                });
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    e.target.disabled = false;
                    document.querySelector('.spinner-border').classList.add('d-none');
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
    },
    mounted() {
        document.title = 'Edit Staff';
        this.id = decryptId(this.$route.params.id);
        this.fetchUserDetails();
    },
};
</script>
