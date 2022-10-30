<template>
    <form @submit.prevent="submit()">
        <div>
            <div v-for="(tab, tabIndex) in tabs" :key="tab.id">
                <div class="col-md-4 offset-md-4 d-flex">
                    <label>Measurement Types</label>
                </div>
                <div class="col-md-4 offset-md-4 d-flex">
                    <select
                        v-model="tab.selectedMeasureType"
                        @change="getMeasureStruct(tabIndex)"
                        class="form-control select2"
                    >
                        <option>select</option>
                        <option
                            v-for="measureType in measureTypes"
                            :key="measureType.id"
                            :value="measureType.id"
                        >
                            {{ measureType.measurementTypeName }}
                        </option>
                    </select>
                    <div class="col-md-4">
                        <button v-if="tabIndex == Object.keys(tabs).length -1" class="btn btn-success btn-sm mt-2 ml-2" @click="addTab">
                            <i class="fa fa-plus"></i>
                        </button>
                        <button class="btn btn-danger btn-sm mt-2 ml-2" @click="removeTab(tabIndex, tab)">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div v-for="(row, rowIndex) in tab.rows" :key="row.id">
                    <table class="table table-borderless col-md-12">
                        <thead>
                        <th class="col-md-2">MeasurementStructure</th>
                        <th class="">StructureNo</th>
                        <th class="col-md-1">Rate</th>
                        <th class="col-md-1">Length(ft)</th>
                        <th class="col-md-1">Width(ft)</th>
                        <th class="col-md-1">Height(ft)</th>
                        <th class="col-md-1">Qty</th>
                        <th class="col-md-2">Amount</th>
                        <th class="col-md-1"></th>
                        </thead>
                        <tbody>
                        <td>
                            <select
                                v-model="row.selectedStructure"
                                @change="getRate(tabIndex, rowIndex)"
                                class="form-control select2"
                            >
                                <option>select</option>
                                <option
                                    v-for="measureStruct in tab.measureStructs"
                                    :key="measureStruct.id"
                                    :value="measureStruct.id"
                                >
                                    {{ measureStruct.measurementStructureName }}
                                </option>
                            </select>
                        </td>
                        <td class="col-md-1">
                            <input
                                class="form-control text-right"
                                type="number"
                                min="0"
                                v-model="row.selectedStructNo"
                                @change="calculateQty(tabIndex,rowIndex)"
                                @input="calculateLineTotal(tabIndex,rowIndex)"
                                @click="calculateLineTotal(tabIndex,rowIndex)"
                            />
                        </td>
                        <td class="col-md-1">
                            <input
                                class="form-control text-right"
                                type="number"
                                min="0"
                                step="any"
                                v-model="row.selectedRate"
                                @change="calculateLineTotal(tabIndex,rowIndex)"
                                @input="calculateLineTotal(tabIndex,rowIndex)"
                                @click="calculateLineTotal(tabIndex,rowIndex)"
                            />
                        </td>
                        <td>
                            <input
                                class="form-control text-right"
                                type="number"
                                min="0"
                                step="any"
                                v-model="row.selectedLength"
                                @change="calculateQty(tabIndex,rowIndex)"
                                @input="calculateLineTotal(tabIndex,rowIndex)"
                                @click="calculateLineTotal(tabIndex,rowIndex)"
                            />
                        </td>
                        <td>
                            <input
                                class="form-control text-right"
                                type="number"
                                min="0"
                                step="any"
                                v-model="row.selectedWidth"
                                @change="calculateQty(tabIndex,rowIndex)"
                                @input="calculateLineTotal(tabIndex,rowIndex)"
                                @click="calculateLineTotal(tabIndex,rowIndex)"
                            />
                        </td>
                        <td>
                            <input
                                class="form-control text-right"
                                type="number"
                                min="0"
                                step="any"
                                name="houseAreaTypeId[][houseAreaCartInfo[qty]]"
                                v-model="row.selectedHeight"
                                @change="calculateQty(tabIndex,rowIndex)"
                                @input="calculateLineTotal(tabIndex,rowIndex)"
                                @click="calculateLineTotal(tabIndex,rowIndex)"
                            />
                        </td>
                        <td>
                            <input
                                class="form-control text-right"
                                type="number"
                                min="0"
                                step=".01"
                                name="houseAreaTypeId[][houseAreaCartInfo[qty]]"
                                v-model="row.selectedQty"
                                @change="calculateLineTotal(tabIndex,rowIndex)"
                                @input="calculateLineTotal(tabIndex,rowIndex)"
                                @click="calculateLineTotal(tabIndex,rowIndex)"
                            />
                        </td>
                        <td>
                            <input
                                readonly
                                class="form-control text-right"
                                type="number"
                                min="0"
                                step=".01"
                                name="houseAreaTypeId[][houseAreaCartInfo[totalAmount]]"
                                v-model="row.line_total"
                                @click="calculateLineTotal(tabIndex,rowIndex)"
                            />
                        </td>
                        <td>
                            <button  v-if="rowIndex == Object.keys(tab.rows).length -1" type="button" class="btn btn-success btn-sm mt-2 mr-1" @click="addRow(tabIndex)">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button  type="button"
                                     class="btn btn-danger btn-sm mt-2"
                                     @click="removeRow(rowIndex, row,tabIndex)">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                        </tbody>
                    </table>
                    <hr />
                </div>
            </div>
            <div class="col-md-6 float-right px-0">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">All TotalAmount</label>
                    <div class="col-md-9">
                        <input
                            readonly
                            type="number"
                            class="form-control"
                            step="any"
                            required
                            name="subtotal"
                            v-model="allTotal"
                        />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Total Quantity</label>
                    <div class="col-md-9">
                        <input
                            readonly
                            type="number"
                            class="form-control"
                            step="any"
                            required
                            name="subtotal"
                            v-model="totalQty"
                        />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">disc%</label>
                    <div class="col-md-3">
                        <input
                            type="number"
                            class="form-control"
                            step="any"
                            required
                            name="vat"
                            v-model="disc"
                            @change="calculateTotal(tabIndex)"
                        />
                    </div>
                    <label class="col-md-2 col-form-label"><div class="float-right">Amount</div></label>
                    <div class="col-md-4">
                        <input
                            readonly
                            type="number"
                            class="form-control"
                            step="any"
                            name="vatC"
                            v-model="discC"
                            @change="calculateTotal(tabIndex)"
                        />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Vat%</label>
                    <div class="col-md-3">
                        <input
                            type="number"
                            class="form-control"
                            step="any"
                            required
                            name="vat"
                            v-model="vat"
                            @change="calculateTotal(tabIndex)"
                        />
                    </div>
                    <label class="col-md-2 col-form-label"><div class="float-right">Amount</div></label>
                    <div class="col-md-4">
                        <input
                            readonly
                            type="number"
                            class="form-control"
                            step="any"
                            name="vatC"
                            v-model="vatC"
                            @change="calculateTotal(tabIndex)"
                        />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Grand Total</label>
                    <div class="col-md-9">
                        <input
                            readonly
                            type="number"
                            class="form-control"
                            step="any"
                            required
                            name="total"
                            v-model="finalTotal"
                        />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Advanced</label>
                    <div class="col-md-3">
                        <input
                            type="number"
                            class="form-control"
                            step="any"
                            required
                            name="vat"
                            v-model="adv"
                            @click="calculateTotal(tabIndex)"
                        />
                    </div>
                    <label class="col-md-2 col-form-label text-danger"><div class="float-right">Payable</div></label>
                    <div class="col-md-4">
                        <input
                            readonly
                            type="number"
                            class="form-control"
                            step="any"
                            name="vatC"
                            v-model="payable"
                            @change="calculateTotal(tabIndex)"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 float-right">
            <input type="submit" class="btn btn-success">
        </div>
    </form>
</template>

<script type="module">
    export default {
        data() {
            return {
                tabs: [{
                    selectedMeasureType: "",
                    measureStructs: {},
                    MeasureType: {},
                    tabQty: 0,
                    tabtotal: 0,
                    rows: [{
                        selectedStructure: "",
                        selectedStructNo: "",
                        selectedRate: "",
                        selectedLength: 1,
                        selectedWidth: 1,
                        selectedHeight: 1,
                        selectedQty: "",
                        line_total: 0,
                    }],
                }],
                subtotal: 0,
                allTotal: 0,
                allQty: 0,
                totalQty: 0,
                finalTotal: 0,
                total: 0,
                vatC: 0,
                rate: 0,
                vat: 0,
                discC: 0,
                disc: 0,
                adv: 0,
                payable: 0,
                tabCounter: 0,
                measureTypes: {},
                id: {},
                mId: {},
            };
        },

        methods: {
            addRow(tabIndex) {
                this.tabs[tabIndex].rows.push({
                    selectedStructure: "",
                    selectedStructNo: "",
                    selectedRate: "",
                    selectedLength: 1,
                    selectedWidth: 1,
                    selectedHeight: 1,
                    selectedQty: 0,
                    line_total: 0,
                });
                localStorage.setItem("rows", JSON.stringify(this.rows));
            },
            addTab() {
                this.tabs.push({
                    selectedMeasureType: "",
                    measureStructs: {},
                    MeasureType: {},
                    tabQty: 0,
                    tabtotal: 0,
                    rows: [{
                        selectedStructure: "",
                        selectedStructNo: "",
                        selectedRate: "",
                        selectedLength: 1,
                        selectedWidth: 1,
                        selectedHeight: 1,
                        selectedQty: "",
                        line_total: 0,
                    },
                    ],
                });
                localStorage.setItem("tabs", JSON.stringify(this.tabs));
            },
            getMeasureStruct(tabIndex) {
                axios
                    .get("/api/measure-struct", {
                        params: {
                            measureTypeId: this.tabs[tabIndex].selectedMeasureType,
                        },
                    })
                    .then(
                        function (response) {
                            console.log(response.data);
                            this.tabs[tabIndex].measureStructs = response.data;
                        }.bind(this)
                    );
            },
            getRate(tabIndex,rowIndex) {
                axios
                    .get("/api/rate", {
                        params: {
                            id: this.tabs[tabIndex].selectedMeasureType,
                        },
                    })
                    .then(
                        function (response) {
                            console.log(response.data);
                            this.tabs[tabIndex].MeasureType = response.data;

                            this.tabs[tabIndex].rows[rowIndex].selectedRate =
                                response.data.rate;
                            console.log(response.data.rate);
                        }.bind(this)
                    );
            },
            getMeasureTypes() {
                axios.get("/api/measureTypes").then((response) => {
                    this.measureTypes = response.data;
                });
            },
            submit() {
                axios.post('/api/create-measure-cart', {
                    mt        : this.tabs,
                    finalTotal: this.finalTotal,
                    allTotal  : this.allTotal,
                    totalQty  : this.totalQty,
                    vatC      : this.vatC,
                    discC     : this.discC,
                    adv       : this.adv,
                    payable   : this.payable,
                    id     : window.location.href.split('/').pop(),
                }).then((response) => {
                    this.id = response.data.id;
                    this.mId = response.data.mId;
                    window.location.href=('/view-measure-cart/'+this.id+'/'+this.mId);
                })
            },
            calculateQty(tabIndex,rowIndex) {
                var total =
                    parseFloat(this.tabs[tabIndex].rows[rowIndex].selectedStructNo) *
                    parseFloat(this.tabs[tabIndex].rows[rowIndex].selectedLength) *
                    parseFloat(this.tabs[tabIndex].rows[rowIndex].selectedWidth) *
                    parseFloat(this.tabs[tabIndex].rows[rowIndex].selectedHeight) ;
                if (!isNaN(total)) {
                    this.tabs[tabIndex].rows[rowIndex].selectedQty= total.toFixed(2);
                }
                this.calculateTotal();
            },
            calculateLineTotal(tabIndex,rowIndex) {
                var total =
                    parseFloat(this.tabs[tabIndex].rows[rowIndex].selectedRate) *
                    parseFloat(this.tabs[tabIndex].rows[rowIndex].selectedQty);
                if (!isNaN(total)) {
                    this.tabs[tabIndex].rows[rowIndex].line_total = total.toFixed(2);
                }
                console.log(this.tabs[tabIndex].rows[rowIndex].line_total);
                this.calculateTotal();
            },
            calculateTotal(tabIndex,rowIndex) {
                var subtotal=0;
                var tabtotal=0;
                var allTotal=0;
                var allQty=0;
                var tabQty=0;
                var totalQty=0;
                var finalTotal=0;
                var payable=0;
                var total, discC, adv, vatC;

                for (let tabIndex = 0; tabIndex < this.tabs.length; tabIndex++) {
                    allQty = this.tabs[tabIndex].rows.reduce(function (sum, product) {
                        var selectedQty = parseFloat(product.selectedQty);
                        if (!isNaN(selectedQty)) {
                            return sum + selectedQty;
                        }
                    }, 0);
                    tabQty = allQty;
                    totalQty += allQty;
                    this.totalQty = totalQty.toFixed(2);
                    this.tabs[tabIndex].tabQty = tabQty.toFixed(2);
                }
                for (let tabIndex = 0; tabIndex < this.tabs.length; tabIndex++) {
                    subtotal = this.tabs[tabIndex].rows.reduce(function (sum, product) {
                        var lineTotal = parseFloat(product.line_total);
                        if (!isNaN(lineTotal)) {
                            return sum + lineTotal;
                        }
                    }, 0);
                    tabtotal = subtotal;
                    allTotal += subtotal;
                    this.allTotal = allTotal.toFixed(2);
                    this.tabs[tabIndex].tabtotal = tabtotal.toFixed(2);
                    //or if you pass float numbers , use parseFloat()
                }
                console.log(allTotal);
                this.allTotal = allTotal.toFixed(2);
                total = allTotal - allTotal * (this.disc / 100);
                total = parseFloat(total);
                if (!isNaN(total)) {
                    this.total = total.toFixed(2);
                } else {
                    this.total = "0.00";
                }
                discC  = allTotal * (this.disc / 100);
                discC = parseFloat(discC);
                if (!isNaN(discC)) {
                    this.discC = discC.toFixed(2);
                } else {
                    this.discC = "0.00";
                }
                //vat......
                finalTotal = total * (this.vat / 100) + total;
                finalTotal = parseFloat(finalTotal);
                if (!isNaN(finalTotal)) {
                    this.finalTotal = finalTotal.toFixed(2);
                } else {
                    this.finalTotal = "0.00";
                }
                vatC  = total * (this.vat / 100);
                vatC = parseFloat(vatC);
                if (!isNaN(vatC)) {
                    this.vatC = vatC.toFixed(2);
                } else {
                    this.vatC = "0.00";
                }
                payable = finalTotal - this.adv;
                payable = parseFloat(payable);
                if (!isNaN(payable)) {
                    this.payable = payable.toFixed(2);
                } else {
                    this.payable = "0.00";
                }
            },

            removeRow(rowIndex, row,tabIndex) {
                var idx = this.tabs[tabIndex].rows.indexOf(row);
                console.log(idx, rowIndex);
                if (rowIndex != 0) {
                    this.tabs[tabIndex].rows.splice(idx, 1);
                    localStorage.setItem("rows", JSON.stringify(this.rows));
                }
            },
            removeTab(index, tab) {
                var idx = this.tabs.indexOf(tab);
                console.log(idx, index);
                if (index != 0) {
                    this.tabs.splice(idx, 1);
                    localStorage.setItem("tabs", JSON.stringify(this.tabs));
                }
                this.calculateTotal();
            },
            getTabs() {
                if (window.location.href.split('/').pop()){
                    this.tabs = JSON.parse(localStorage.getItem("tabs"));
                }

            },
        },
        watch: {
            tabs: {
                handler() {
                    localStorage.setItem("tabs", JSON.stringify(this.tabs));
                },
                deep: true,
            },
        },
        mounted() {
            this.getMeasureTypes();
            if (localStorage.getItem("tabs")) {
                this.getTabs();
            }
            this.calculateTotal();
        },
    };
</script>

<style scoped>
</style>
