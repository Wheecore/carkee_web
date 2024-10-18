const routes = [
    {
        path: '/login',
        name: 'Login',
        component: () => import('./components/Login')
    },
    {
        path: '/forgot-password',
        name: 'Forgot Password',
        component: () => import('./components/ForgotPassword')
    },
    // Admin Routes
    {
        path: '/admin/dashboard',
        name: 'Dashboard',
        component: () => import('./admin/Dashboard'),
    },
    {
        path: '/admin/profile',
        name: 'Profile',
        component: () => import('./admin/Profile')
    },
    {
        path: '/admin/orders',
        name: 'Orders',
        component: () => import('./admin/orders/Orders')
    },
    {
        path: '/admin/orders/:id/edit',
        name: 'Edit Order',
        component: () => import('./admin/orders/EditOrder')
    },
    {
        path: '/admin/orders/:id',
        name: 'Order Details',
        component: () => import('./admin/orders/OrderDetails')
    },
    {
        path: '/admin/inventory',
        name: 'Inventory',
        component: () => import('./admin/Inventory')
    },
    {
        path: '/admin/users',
        name: 'Users',
        component: () => import('./admin/users/Users')
    },
    {
        path: '/admin/users/create',
        name: 'Add User',
        component: () => import('./admin/users/AddUser')
    },
    {
        path: '/admin/users/:id/edit',
        name: 'Edit User',
        component: () => import('./admin/users/EditUser')
    },
    {
        path: '/admin/users/:id',
        name: 'User Details',
        component: () => import('./admin/users/UserDetails')
    },
    {
        path: '/admin/customers',
        name: 'Admin Customers',
        component: () => import('./admin/customers/Customers')
    },
    {
        path: '/admin/customers/create',
        name: 'Admin Add Customer',
        component: () => import('./admin/customers/AddCustomer')
    },
    {
        path: '/admin/customers/:id/edit',
        name: 'Admin Edit Customer',
        component: () => import('./admin/customers/EditCustomer')
    },
    {
        path: '/admin/customers/:id',
        name: 'Admin Customer Details',
        component: () => import('./admin/customers/CustomerDetails')
    },
    {
        path: '/admin/credit-notes',
        name: 'Admin Credit Notes',
        component: () => import('./admin/CreditNotes')
    },
    // User Routes
    {
        path: '/dashboard',
        name: 'User Dashboard',
        component: () => import('./user/Dashboard'),
    },
    {
        path: '/profile',
        name: 'User Profile',
        component: () => import('./user/Profile')
    },
    {
        path: '/orders',
        name: 'User Orders',
        component: () => import('./user/orders/Orders')
    },
    {
        path: '/orders/create',
        name: 'User Add Order',
        component: () => import('./user/orders/AddOrder')
    },
    {
        path: '/orders/:id',
        name: 'User Order Details',
        component: () => import('./user/orders/OrderDetails')
    },
    {
        path: '/customers',
        name: 'Customers',
        component: () => import('./user/customers/Customers')
    },
    {
        path: '/customers/create',
        name: 'Add Customer',
        component: () => import('./user/customers/AddCustomer')
    },
    {
        path: '/customers/:id/edit',
        name: 'Edit Customer',
        component: () => import('./user/customers/EditCustomer')
    },
    {
        path: '/customers/:id',
        name: 'Customer Details',
        component: () => import('./user/customers/CustomerDetails')
    },
];

export default routes;
