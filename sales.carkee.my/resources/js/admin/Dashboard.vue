<template>
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5>Inventory</h5>
                            <h1 class="display-5 mb-0">{{ stats.products }}</h1>
                        </div>
                        <div class="ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="#25396f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5>Orders</h5>
                            <h1 class="display-5 mb-0">{{ stats.orders }}</h1>
                        </div>
                        <div class="ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="#25396f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="20.5" r="1"></circle><circle cx="18" cy="20.5" r="1"></circle><path d="M2.5 2.5h3l2.7 12.4a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6l1.6-8.4H7.1"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5>Staff</h5>
                            <h1 class="display-5 mb-0">{{ stats.staff }}</h1>
                        </div>
                        <div class="ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="#25396f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div>
                            <h5>Customers</h5>
                            <h1 class="display-5 mb-0">{{ stats.customers }}</h1>
                        </div>
                        <div class="ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="#25396f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
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
            id: localStorage.getItem('id'),
            stats: {}
        }
    },
    methods: {
        async dashboard() {
            await axios.post('/api/admin/dashboard', {
                id: this.id
            })
            .then(response => {
                this.stats = response.data;
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
        document.title = 'Dashboard';
        this.dashboard();
    },
}
</script>
