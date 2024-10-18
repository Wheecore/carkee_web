<template>
    <div class="sidebar">
        <div class="sidebar-header">
            <span class="sidebar-logo"><span></span></span>
            <span class="sidebar-logo-text">Carkee Sales</span>
        </div>
        <div class="sidebar-body">
            <nav class="nav-sidebar">
                <router-link to="/dashboard" class="nav-link">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"></path>
                    </svg>
                    <span>Dashboard</span>
                </router-link>
                <router-link to="/customers" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="#25396f" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Customers</span>
                </router-link>
                <router-link to="/orders" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#25396f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="10" cy="20.5" r="1" />
                        <circle cx="18" cy="20.5" r="1" />
                        <path d="M2.5 2.5h3l2.7 12.4a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6l1.6-8.4H7.1" />
                    </svg>
                    <span>Orders</span>
                </router-link>
                <router-link to="/orders/create" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="#25396f" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M6 2L3 6v14c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2V6l-3-4H6zM3.8 6h16.4M16 10a4 4 0 1 1-8 0" />
                    </svg>
                    <span>Add Order</span>
                </router-link>
                <router-link to="/profile" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="#25396f" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3" />
                        <circle cx="12" cy="10" r="3" />
                        <circle cx="12" cy="12" r="10" />
                    </svg>
                    <span>My Profile</span>
                </router-link>
                <button @click.prevent="logout" class="nav-link btn-nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="#25396f" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M16 17l5-5-5-5M19.8 12H9M13 22a10 10 0 1 1 0-20" />
                    </svg>
                    <span>Sign Out</span>
                </button>
            </nav>
        </div>
        <div class="sidebar-footer">
            <div class="avatar online">
                <span class="avatar-initial"></span>
            </div>
            <div class="avatar-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h6>{{ name }}</h6>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: ''
        }
    },
    methods:{
        async logout() {
            await axios.post('/api/logout')
            .then(response => {
                localStorage.removeItem('token');
                localStorage.removeItem('role');
                localStorage.removeItem('id');
                localStorage.removeItem('name');
                window.location.href = '/';
            })
                .catch(error => {
                console.error('Logout error:', error);
            });
        },
    },
    mounted() {
        this.name = localStorage.getItem('name');
    },
};
</script>
