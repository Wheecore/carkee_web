<template>
	<div @click="handleContainerClick">
		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow">
					<div class="card-body">
						<h4 class="mb-4">Edit Order</h4>
						<form @submit.prevent="editOrderDetails">
							<div class="row mb-4">
								<div class="col-md-3">
									<div class="form-group">
										<label for="status">Status</label>
										<select class="form-control" v-model="order.status"
												style="appearance: menulist">
											<option value="0">Pending</option>
											<option value="1">Out for Delivery</option>
											<option value="2">Completed</option>
										</select>
									</div>
								</div>
								<div class="col-md-9">
									<div class="form-group">
										<label for="">Select Customer</label>
										<span class="text-danger"> *</span>
										<select :class="['form-control', {'is-invalid': customer_id_error}]"
												v-model="customer_id" @change="populateCustomer">
											<option value="">-- Choose --</option>
											<option v-for="customer in customers" :key="customer.id"
													:value="customer.id">
												{{ customer.name }}
											</option>
										</select>
										<span class="invalid-feedback" v-if="customer_id_error" role="alert">
                                        <strong>{{ customer_id_error }}</strong>
                                    </span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group mb-4">
										<label for="">Company Name</label>
										<span class="text-danger"> *</span>
										<input type="text" class="form-control" v-model="customer.name" disabled>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-4">
										<label for="">Company Number</label>
										<span class="text-danger"> *</span>
										<input type="text" class="form-control" v-model="customer.company_number"
											   disabled>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group mb-4">
										<label for="">Company Phone</label>
										<span class="text-danger"> *</span>
										<input type="text" class="form-control" v-model="customer.company_phone"
											   disabled>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-4">
										<label for="">PIC Name</label>
										<span class="text-danger"> *</span>
										<input type="text" class="form-control" v-model="customer.pic_name" disabled>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-4">
										<label for="">PIC Phone</label>
										<span class="text-danger"> *</span>
										<input type="text" class="form-control" v-model="customer.pic_phone" disabled>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group mb-4">
										<label for="">Address</label>
										<span class="text-danger"> *</span>
										<textarea class="form-control" rows="2" v-model="customer.address"
												  disabled></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group mb-4">
										<label for="">Payment Terms</label>
										<span class="text-danger"> *</span>
										<select :class="['form-control', {'is-invalid': payment_term_error}]"
												name="payment_term" v-model="payment_term" disabled>
											<option value="">-- Choose --</option>
											<option value="COD">C.O.D</option>
											<option value="Credit Note">Credit Note</option>
										</select>
										<span class="invalid-feedback" v-if="payment_term_error" role="alert">
                                        <strong>{{ payment_term_error }}</strong>
                                    </span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-4">
										<label for="">Payment Due Date</label>
										<span class="text-danger"> *</span>
										<input type="date"
											   :class="['form-control', {'is-invalid': payment_due_date_error}]"
											   name="payment_due_date" v-model="payment_due_date">
										<span class="invalid-feedback" v-if="payment_due_date_error" role="alert">
                                        <strong>{{ payment_due_date_error }}</strong>
                                    </span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group mb-4">
										<label for="">Products</label>
										<span class="text-danger"> *</span>
										<select data-live-search="true"
												:class="['form-control products-select', {'is-invalid': products_error}]"
												v-model="selected_products" ref="select" multiple>
											<option v-for="option in products" :key="option.id" :value="option.id"
													:data-amount="option.amount" :data-disc="option.disc" :data-name="option.name">
												{{ option.name }}
											</option>
										</select>
										<span class="invalid-feedback" v-if="products_error" role="alert">
                                        <strong>{{ products_error }}</strong>
                                    </span>
										<button type="button" class="btn btn-primary mt-3" @click="addProductsRows">Add
											Products
										</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group mb-4">
										<table class="table">
											<thead class="thead-light">
											<th width="5%">S/N</th>
											<th width="5%">CODE</th>
											<th width="30%">DESCRIPTION</th>
											<th width="5%">QTY</th>
											<th width="5%">FOC</th>
											<th width="10%">UOM</th>
											<th width="10%">UNIT PRICE</th>
											<th width="10%">DISC %</th>
											<th width="10%">AMOUNT</th>
											<th width="10%">ACTION</th>
											</thead>
											<tbody>
											<tr v-for="(row, index) in rows" :key="index" :id="row.id">
												<template v-if="!row.isDeleted">
													<td width="5%">{{ index + 1 }}</td>
													<td width="5%">-</td>
													<td width="30%">{{ row.name }}</td>
													<td width="10%">
														<input type="number" class="form-control"
															   @input="updateQuantity" :data-key="row.id"
															   :id="'qty-' + row.id" v-model="row.qty"/>
													</td>
													<td width="10%">
														<input type="number" class="form-control"
															   v-model="row.foc"/>
													</td>
													<td width="10%">
														<select class="form-control" v-model="row.uom">
															<option value="PCS">PCS</option>
														</select>
													</td>
													<td width="10%">{{ parseFloat(row.amount) }}</td>
													<td width="10%"><input type="number" step="0.01"
																		   class="form-control" @input="calculateTotal"
																		   :id="'disc-' + row.id" v-model="row.disc"
																		   readonly/></td>
													<td width="10%" :id="'sub-total-' + row.id">{{
															(parseInt(row.qty) * parseFloat(row.amount)) - (parseFloat(row.disc) / 100 * (parseInt(row.qty) * parseFloat(row.amount)))
														}}
													</td>
													<td width="10%">
														<button type="button" class="btn btn-outline-danger"
																@click="deleteProductRow(row)">
															Delete
														</button>
													</td>
												</template>
											</tr>
											</tbody>
											<tfoot>
											<tr>
												<td colspan="8" class="text-right border-unset">SUBTOTAL (MYR):</td>
												<td class="border-unset">{{ totalAmount }}</td>
											</tr>
											<tr>
												<td colspan="8" class="text-right border-unset">TAX (MYR):</td>
												<td class="border-unset">0.00</td>
											</tr>
											<tr>
												<td colspan="8" class="text-right border-unset">TOTAL (MYR):</td>
												<td class="border-unset">{{ totalAmount }}</td>
											</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
							<div class="row text-right">
								<div class="col-md-12">
									<hr>
									<button class="btn btn-md btn-primary" type="submit">
										Submit
										<div class="spinner-border d-none" role="status"></div>
									</button>
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
import '../../assets/js/bootstrap-select.min.js';
import {decryptId} from '../../services/cryptoUtils';
import Swal from "sweetalert2";

export default {
	data() {
		return {
			id: '',
			order: {},
			user_id: '',
			order_items: {},
			customers: [],
			products: [],
			customer: {},
			rows: [],
			customer_id: '',
			payment_term: '',
			payment_due_date: '',
			selected_products: [],
			customer_id_error: '',
			payment_term_error: '',
			payment_due_date_error: '',
			products_error: '',
			totalAmount: 0,
		}
	},
	methods: {
		decryptId,
		async fetchOrderDetails() {
			await axios.post('/api/orders/show', {
				id: this.id,
			})
				.then(response => {
					this.user_id = response.data.user_id;
					this.order = response.data.order;
					this.customer_id = this.order.customer_id;
					this.totalAmount = this.order.total;
					this.payment_term = this.order.payment_term,
						this.payment_due_date = this.order.payment_due_date,
						this.customer_po_no = this.order.customer_po_no,
						this.do_no = this.order.do_no,
						this.rows = response.data.order_items;
					this.selected_products = this.rows.map(orderItem => orderItem.id);
					this.fetchCustomers();
				})
				.catch(error => {
					console.error("There was an error!", error);
				});
		},
		async fetchCustomers() {
			await axios.post('/api/get-order-customers', {
				id: this.user_id
			})
				.then(response => {
					this.customers = response.data;
					this.populateCustomer();
				})
				.catch(error => {
					console.error("There was an error!", error);
				});
		},
		async fetchProducts() {
			await axios.post('/api/get-products')
				.then(response => {
					this.products = response.data;
					this.$nextTick(() => {
						$('.products-select').selectpicker("refresh");
					});
				})
				.catch(error => {
					this.authenticateRequest();
				});
		},
		handleContainerClick(event) {
			if (event.target.classList.contains('dropdown-toggle') || event.target.classList.contains('filter-option') || event.target.classList.contains('filter-option-inner') || event.target.classList.contains('filter-option-inner-inner')) {
				if (!event.target.classList.contains('bs-placeholder')) {
					if (document.querySelector('.dropdown-menu').classList.contains('show')) {
						document.querySelector('.dropdown-menu').classList.remove('show');
					} else {
						document.querySelector('.dropdown-menu').classList.add('show');
					}
					if (document.querySelector('.inner').classList.contains('show')) {
						document.querySelector('.inner').classList.remove('show');
					} else {
						document.querySelector('.inner').classList.add('show');
					}
					if (document.querySelector('ul.dropdown-menu').classList.contains('show')) {
						document.querySelector('ul.dropdown-menu').classList.remove('show');
					} else {
						document.querySelector('ul.dropdown-menu').classList.add('show');
					}
				}
			} else {
				document.querySelector('.dropdown-menu').classList.remove('show');
				document.querySelector('.inner').classList.remove('show');
				document.querySelector('ul.dropdown-menu').classList.remove('show');
			}
		},
		populateCustomer() {
			this.customer = this.customers.find(obj => obj.id === this.customer_id);
		},
		addProductsRows() {
			this.selected_products.forEach(option => {
				if (this.selected_products.includes(option) && !this.rows.includes(this.selectedOption) && !document.getElementById(option)) {
					const selected_option = this.$refs.select.querySelector(`option[value="${option}"]`).dataset;
					this.rows.push({
						'id': option,
						'name': selected_option.name,
						'amount': selected_option.amount,
						'qty': 1,
						'foc': 0,
						'uom': 'PCS',
						'disc': selected_option.disc,
						'isDeleted': false
					});
				}
			});
			this.calculateTotal();
		},
		deleteProductRow(row) {
			row.isDeleted = true
			this.calculateTotal()
		},
		updateQuantity(e) {
			const key = parseInt(e.target.dataset.key);
			const option = this.products.find(obj => obj.id === key);
			const amount = parseInt(e.target.value) * parseFloat(option.amount);
			var discountAmount = parseFloat(document.getElementById('disc-' + key).value) / 100 * amount;
			document.getElementById('sub-total-' + parseInt(e.target.dataset.key)).innerHTML = amount - discountAmount;
			this.calculateTotal();
		},
		calculateTotal() {
			this.totalAmount = this.rows.reduce((total, item) => {
				const amount = parseInt(item.qty) * parseFloat(item.amount);
				const discountAmount = parseFloat(item.disc) / 100 * amount;
				return item.isDeleted ? total : total + (amount - discountAmount);
			}, 0);
		},
		authenticateRequest() {
			localStorage.removeItem('token');
			localStorage.removeItem('role');
			localStorage.removeItem('id');
			window.location.href = '/';
		},
		async editOrderDetails(e) {
			this.customer_id_error = '';
			this.payment_term_error = '';
			this.payment_due_date_error = '';
			this.products_error = '';
			e.target.disabled = true;
			document.querySelector('.spinner-border').classList.remove('d-none');
			await axios.post('/api/admin/orders/update', {
				id: this.id,
				customer_id: this.customer_id,
				payment_term: this.payment_term,
				payment_due_date: this.payment_due_date,
				products: this.rows,
				status: this.order.status,
			})
				.then(response => {
					e.target.disabled = false;
					document.querySelector('.spinner-border').classList.add('d-none');
					Swal.fire({
						title: "Success",
						text: response.data.message,
						icon: "success",
					}).then((result) => {
						this.$router.push("/admin/orders");
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
		document.title = 'Edit Order';
		this.id = decryptId(this.$route.params.id);
		this.fetchOrderDetails();
		this.fetchProducts();
	},
};
</script>
<style>
@import "../../assets/css/bootstrap-select.min.css";
</style>
