<template>
  <div>
    <div class="row">
        <div class="col-lg-12">
            <h4 class="mb-4">
                Order Details
                <button @click="deleteOrder" :data-id="order.id" class="btn btn-sm btn-danger btn-delete float-right mr-1" data-bs-toggle="modal" data-bs-target="#delete">Delete</button>
                <button @click="downloadInvoice" class="btn btn-sm btn-primary float-right mr-1">
                    Invoice
                    <div class="spinner-border d-none" role="status"></div>
                </button>
                <router-link :to="'/admin/orders/' + encryptId + '/edit'" class="btn btn-sm btn-primary float-right mr-1">Edit</router-link>
            </h4>
            <hr>
            <div class="card shadow">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <img v-bind:src="'https://carkee.my/public/uploads/all/PDlvp1gGXHjyiGTeWvqwoUFlJDaZAsfngDqnvI1X.png'" style="width: 250px;" class="img-fluid mb-3">
                            </div>
                            <div class="form-group">
                                <h4>Carkee Automotive Sdn Bhd</h4>
                                <p class="mb-1">9, Jalan Linggis 15/24, Seksyen 15, 40200 Shah Alam, Selangor</p>
                                <p>Telephone: 0123440911 Email: enquiry@carkee.my</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group float-left">
                                {{ order.created_at }}
                            </div>
                            <div class="form-group float-right">
                                <h5>SALES ORDER</h5>
                                <h6>Number: {{ order.code }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>SOLD TO:</th>
                                            <th>DELIVER TO:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border-2px">
                                                <p class="mb-1"><strong>Customer Code</strong>: {{ order.customer_code }}</p>
                                                <p class="mb-1"><strong>{{order.name}}</strong></p>
                                                <p class="mb-1"><strong>Contact Person</strong>: {{ order.pic_name }} ({{order.pic_name && order.pic_phone ? order.pic_phone : '-'}})</p>
                                                <p><strong>Tel</strong>: {{ order.company_phone }}</p>
                                            </td>
                                            <td class="border-2px">
                                                <p>{{ order.address }}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="border-2px">SALES PERSON</th>
                                                <th class="border-2px">PAYMENT TERMS</th>
                                                <th class="border-2px">PAYMENT DUE DATE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="border-2px">{{ sales_person }}</td>
                                                <td class="border-2px">{{ order.payment_term }}</td>
                                                <td class="border-2px">{{ order.payment_due_date }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="border-2px">S/N</th>
                                                <th class="border-2px">CODE</th>
                                                <th class="border-2px">DESCRIPTION</th>
                                                <th class="border-2px">QTY</th>
                                                <th class="border-2px">FOC</th>
                                                <th class="border-2px">UOM</th>
                                                <th class="border-2px">UNIT PRICE</th>
                                                <th class="border-2px">DISC %</th>
                                                <th class="border-2px">AMOUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-tr-2px" v-for="(item, index) in order_items" :key="item.id">
                                                <td>{{ index + 1 }}</td>
                                                <td>-</td>
                                                <td>{{ item.name }}</td>
                                                <td>{{ item.qty }}</td>
                                                <td>{{ item.foc }}</td>
                                                <td>{{ item.uom }}</td>
                                                <td>RM {{ item.amount }}</td>
                                                <td>{{ item.disc }}</td>
                                                <td>RM {{ (parseInt(item.qty) * parseFloat(item.amount)) - (parseFloat(item.disc)/100 * (parseInt(item.qty) * parseFloat(item.amount))) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <h5><u>OTHER INFORMATION</u></h5>
                            <h6>Note:</h6>
                            <h6>Terms & Condition:</h6>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mb-4">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="5">SUBTOTAL (MYR)</td>
                                            <td>RM {{ order.total }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">TAX (MYR)</td>
                                            <td>RM 0.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">TOTAL (MYR)</td>
                                            <td>RM {{ order.total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="border-2px">
                        <div class="row p-2">
                            <div class="col-md-12">
                                <div class="form-group float-left">
									<p class="mb-1">Beneficiary Bank: MAYBANK</p>
									<p class="mb-1">Beneficiary Account No: 562683215043</p>
                                </div>
                                <div class="form-group float-right">
                                    <h5>Carkee Automotive Sdn Bhd</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import { decryptId } from '../../services/cryptoUtils';
export default {
    data() {
        return {
            encryptId: '',
            id: '',
            sales_person: '',
            order: {},
            order_items: {},
        }
    },
    methods: {
        decryptId,
        async fetchOrderDetails() {
            await axios.post('/api/orders/show', {
                id: this.id,
            })
            .then(response => {
                this.order = response.data.order;
                this.sales_person = this.order.staff;
                this.order_items = response.data.order_items;
            })
            .catch(error => {
                console.error("There was an error!", error);
            });
        },
        async downloadInvoice(e) {
            e.target.disabled = true;
            document.querySelector('.spinner-border').classList.remove('d-none');
            await axios.post('/api/pdf', {
                id: this.id,
            })
            .catch(error => {
                e.target.disabled = false;
                document.querySelector('.spinner-border').classList.add('d-none');
            });
        },
    },
    mounted() {
        document.title = 'Order Details';
        this.encryptId = this.$route.params.id;
        this.id = decryptId(this.$route.params.id);
        this.fetchOrderDetails();
    },
};
</script>
