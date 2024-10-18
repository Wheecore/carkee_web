<template>
  <div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4">
                        Staff Details
                        <button class="btn btn-sm btn-danger float-right mr-1" data-bs-toggle="modal" data-bs-target="#delete">Delete</button>
                        <router-link :to="'/admin/users/' + encryptId + '/edit'" class="btn btn-sm btn-primary float-right mr-1">Edit</router-link>
                    </h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="">Name</label>
                                <p>{{ user.name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="">Email</label>
                                <p>{{ user.email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="">Created</label>
                                <p>{{ user.created_at }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="">Status</label>
                                <p>
                                    <span class="badge badge-danger" v-if="user.status == 0">Inactive</span>
                                    <span class="badge badge-success" v-else>Active</span>
                                </p>
                            </div>
                        </div>
                    </div>
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
                    <button @click="confirmDeleteUser" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>
<script>
import { decryptId } from '../../services/cryptoUtils';
import Swal from "sweetalert2";
export default {
    data() {
        return {
            encryptId: '',
            id: '',
            user: {}
        }
    },
    methods: {
        decryptId,
        async fetchUserDetails() {
            await axios.post('/api/admin/users/show', {
                id: this.id,
            })
            .then(response => {
                if (response.data.user) {
                    this.user = response.data.user;
                } else {
                    Swal.fire({
                        title: "Warning",
                        text: 'Something went wrong!',
                        icon: "warning",
                    });
                }
            })
            .catch(error => {
                console.error("There was an error!", error);
            });
        },
        async confirmDeleteUser()
        {
            await axios.post('/api/admin/users/delete', {
                id: this.id
            })
            .then(response => {
                Swal.fire({
                    title: "Success",
                    text: response.data.message,
                    icon: "success",
                });
                location.reload();
            })
            .catch(error => {
                console.error("There was an error!", error);
            });
        },
    },
    mounted() {
        document.title = 'Staff Details';
        this.encryptId = this.$route.params.id;
        this.id = decryptId(this.encryptId);
        this.fetchUserDetails();
    },
};
</script>
