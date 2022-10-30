<template>
    <form>
        <div class="form-group row">
            <div class="col-md-6">
                <label>Purchase Category<span style='color: #ff0000;'>*</span></label>
                <input type="text" class="form-control" v-model="purchaseCategory"  />
            </div>
            <div class="col-md-6">
                <label>User Name<span style='color: #ff0000;'>*</span></label>
                <input type="text" class="form-control" v-model="userId" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label>Client Name<span style='color: #ff0000;'>*</span></label>
                <select id="uuu" class="form-control select2 bg-white" v-model="clientId"  >
                    <option value="" selected>select clients</option>
                    <option v-for="client in clients" :key="client.id" :value="client.id">{{client.clientName}}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Supplier Name<span style='color: #ff0000;'>*</span></label>
                <select id="oi" class="form-control select2 bg-white" v-model="supplierId">
                    <option value="" selected>select suppliers</option>
                    <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{supplier.companyOrStoreName}}</option>
                </select>
            </div>
        </div>
        <div class="form-group row" v-for="(key, keyIndex) in products" :key="key.id">
            <div class="col-md-3">
                <label>Product Name<span style='color: #ff0000;'>*</span></label>
                <select id="yt" class="form-control select2 bg-white" v-model="key.productId"  >
                    <option value="" selected>select product</option>
                    <option v-for="good in goods"  :value="good.id">{{good.productName}}</option>
                </select>

            </div>
            <div class="col-md-2">
                <label>Quantity<span style='color: #ff0000;'>*</span></label>
                <input type="number" class="form-control" v-model="key.quantity"  @change="calculateRowTotal(keyIndex)" />
            </div>

            <div class="col-md-2">
                <label>Rate<span style='color: #ff0000;'>*</span></label>
                <input type="text" class="form-control" v-model="key.rate"  @change="calculateRowTotal(keyIndex)" />
            </div>
            <div class="col-md-3">
                <label>Price<span style='color: #ff0000;'>*</span></label>
                <input readonly type="number" min="0" step=".01" class="form-control" v-model="key.price" />
            </div>
            <div class="col-md-2">
                <label>Add Fields</label><br>
                <a  class="btn btn-success btn-sm" @click="add" title="add" id="add_more_fields">
                    <i class="fa fa-plus-circle"></i>
                </a>
                <a  class="btn btn-danger btn-sm" @click="remove" title="remove">
                    <i class="fa fa-minus-circle"></i>
                </a>
            </div>

        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label>Sub Total</label>
                <input readonly type="number" class="form-control" v-model="subTotal"  />
            </div>
            <div class="col-md-6">
                <label>Discount(%)</label>
                <input type="number" class="form-control" v-model="discount" @change="calculateGrandTotal()" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label>Vat(%)</label>
                <input  type="number" class="form-control" v-model="vat" @change="calculateGrandTotal()" />
            </div>
            <div class="col-md-4">
                <label>Payment</label>
                <input type="number" class="form-control" v-model="paid" @change="calculateGrandTotal()" />
            </div>
            <div class="col-md-4">
                <label>Due</label>
                <input readonly type="number" class="form-control" v-model="grandTotal" />
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label>Grand Total</label>
                <input readonly type="text" class="form-control" v-model="grandTotal" />
            </div>
            <div class="col-md-6">
                <label>Date<span style='color: #ff0000;'>*</span></label>
                <input type="date" class="form-control" v-model="date" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label"></label>
            <div class="col-md-8">
                <input type="submit" class="btn btn-success" v-on:click="submit" value="Submit" />
            </div>
        </div>
    </form>
</template>

<script type="module">
export default {
    props:['userr'],
    data(){
        return{
            count:1,
            users:{},
            goods:[{
                productName: ''
            }],
            suppliers:[{
                companyOrStoreName: ''
            }],
            clients:[{
                clientName: '',
            }],
            purchaseCategory: '',
            userId: '',
            clientId:'',
            supplierId:'',
            products: [{
                    productId: 'select product',
                    quantity: '',
                    rate: '',
                    price:0,
                }],
            lineTotal:0,
            allTotal:0,
            subTotal:0,
            grandTotal:0,
            due: 0,
            date: '',
            paid: 0,
            status: '',
            discount:0,
            vat:0

        }
    },
    methods:{
        getSupplier(){
            axios.get("api/table-data").then((response)=>{
                this.suppliers = response.data;
            });
        },
        getClient(){
            axios.get("api/client-data").then((response)=>{
                // this.clients = response.data;
                console.log(response);
            });
        },
        getProduct(){
            axios.get("api/product-data").then((response)=>{
                this.goods = response.data;
            });
        },
        getUser(){
            this.userId = this.userr.name;
            console.log(this.userId);

        },
        add: function() {
            // this.products++;
            this.products.push({
                productId: 'select product',
                quantity: '',
                rate: '',
                price: '',
            });
            localStorage.setItem("products", JSON.stringify(this.products));
        },
        remove: function(index,key) {
            // this.products--;
            var idx = this.products.indexOf(key);
            console.log(idx, index);
            if (index != 1) {
                this.products.splice(idx, 1);
                localStorage.setItem("products", JSON.stringify(this.products));
            }
            this.calculateTotal();
        },
        calculateRowTotal(keyIndex){
           var total = parseFloat(this.products[keyIndex].quantity)* parseFloat(this.products[keyIndex].rate);
            if (!isNaN(total)) {
                this.products[keyIndex].price = total.toFixed(2);
            }
            this.calculateTotal();
        },
        calculateTotal(keyIndex){
            var lineTotal=0;

            // for (let keyIndex = 0; keyIndex < this.products.length; keyIndex++) {
            //
            // }
            lineTotal= this.products.reduce(function (a,b){
                var rowTotal = parseFloat(b.price);
                return a + rowTotal;
            },0);
            console.log(lineTotal);
            this.subTotal = lineTotal.toFixed(2);
        },
        calculateGrandTotal(){
            var discount = 0;
            var amount = 0;
            var vaT = 0;
            var finalAmount = 0;
            discount = this.subTotal * (this.discount/100);
            amount = this.subTotal - discount;
            vaT = this.subTotal * (this.vat/100);
            finalAmount = amount + vaT;
            finalAmount = finalAmount - this.paid;
            console.log(finalAmount);
            this.grandTotal = finalAmount.toFixed(2);

        },
        submit(){


        }

    },
    mounted() {
        this.getSupplier();
        this.getClient();
        this.getProduct();
        this.getUser();
        this.calculateRowTotal();
        this.calculateTotal();
        this.calculateGrandTotal()
        // axios.get("api/table-data").then( response=>{
        //     this.suppliers = response.data.data;
        // })
    }
}
</script>
