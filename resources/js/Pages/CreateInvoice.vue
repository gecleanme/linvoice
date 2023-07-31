<script setup>
import {useForm} from "@inertiajs/vue3";
import {computed, watch} from 'vue';


const format = (date) => {
    if (!(date instanceof Date)) {
        date = new Date(date);
    }
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
}

const formData = useForm({
    companyName: null,
    logoURL: null,
    invoiceNum:null,
    issueDate:null,
    dueDate: null,
    address:null,
    issuerPhone:null,
    issuerEmail:null,
    billedToEst:null,
    billedToAddress:null,
    billedToEmail:null,
    Status:"Sent",
    currency: "",
    itemsNum:1,
    items: Array.from({ length: 1 }, () => ({ description: '', price: '' })),
    invoiceTotal:0,
    paymentMethod:"Credit Card",
    paperSize:'A4',

});

const reset = () => formData.reset();

let formatter = new Intl.NumberFormat('en-US', {
    style: 'decimal',
    minimumFractionDigits: 2, // always two decimals
    useGrouping: true, // This will add commas as thousand separator
});




watch(() => formData.itemsNum, (newVal, oldVal) => {

    //protect against nullification & less than 1

    if (newVal === null || newVal<1) {
        formData.itemsNum = 1;
    }

    if (newVal > oldVal) {
        // If num increased, add new items
        formData.items.push(...Array.from({ length: newVal - oldVal }, () => ({ description: '', price: '' })));
    } else {
        // If num decreased, remove items
        formData.items.splice(newVal);
    }
});


const total = computed(() => formData.items.reduce((sum, item) => {
    const price = Number(item.price.replace(/,/g, '')); // Remove commas to keep total a true number
    return sum + price;
}, 0).toFixed(3));

watch(total, (newTotal) => {
    formData.invoiceTotal = formatter.format(newTotal);
});


const sendData = () => {
    formData.post("/getpdf");
}

</script>

<template>
    <Head title="Contract Create" />
    <form @submit.prevent="sendData">
        <!-- Template Start   -->
        <!-- component -->
        <!-- Alert    -->
        <div
            class="min-h-screen p-6 bg-gray-100 flex items-center justify-center"
        >
            <div class="container max-w-screen-lg mx-auto">
                <div>
                    <h2 class="font-semibold text-xl text-gray-600">
                        Create an Invoice
                    </h2>

                    <p class="text-gray-500 mb-6">
                        Required fields are marked with
                        <span class="text-sm text-red-500">* </span>
                    </p>

                    <div
                        class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6"
                    >
                        <div
                            class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3"
                        >
                            <div class="text-gray-600">
                                <p class="font-medium text-lg mb-4">
                                    PDF Details
                                </p>
                                <!--    instructions             -->
                                <p class="tracking-widest leading-tight">Fill out the invoice details & click on "Preview & Download PDF when ready</p>
                            </div>

                            <div class="lg:col-span-2">
                                <div
                                    class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5 rounded-md border-white outline-white"
                                >

                                    <!--Image Link -->
                                    <div class="md:col-span-5">
                                        <label
                                            for="logo_url"
                                            class="font-semibold"
                                        >Public Logo URL</label
                                        >
                                        <span class="text-sm text-red-500">* </span>
                                        <p class="text-sm text-gray-600 mt-2">Must be publicly accessible</p>
                                        <p class="text-sm text-gray-600 mt-2">PNG, JPG or SVG extension</p>


                                        <input
                                            type="text"
                                            v-model="formData.logoURL"
                                            id="logo_url"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.logoURL"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.logoURL }}
                                        </p>
                                    </div>

                                    <!--  name  -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="company_name"
                                            class="font-semibold"
                                        >Issuer Name</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <input
                                            type="text"
                                            v-model="formData.companyName"
                                            id="company_name"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.companyName"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.companyName }}
                                        </p>
                                    </div>



                                    <!--                Address                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="company_address"
                                            class="font-semibold"
                                        > Issuer Address</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <input
                                            type="text"
                                            v-model="formData.address"
                                            id="company_address"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.address"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.address }}
                                        </p>
                                    </div>



                                    <!--                Contact Email                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="issuer_email"
                                            class="font-semibold"
                                        > Issuer Contact Email</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <input
                                            type="text"
                                            v-model="formData.issuerEmail"
                                            id="issuer_email"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.issuerEmail"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.issuerEmail }}
                                        </p>
                                    </div>


                                    <!--                Contact Phone                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="issuer_phone"
                                            class="font-semibold"
                                        > Issuer Contact Phone</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <input
                                            type="text"
                                            v-model="formData.issuerPhone"
                                            id="issuer_phone"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.issuerPhone"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.issuerPhone }}
                                        </p>
                                    </div>

                                    <!--                Invoice Number                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="invoice_num"
                                            class="font-semibold"
                                        >Invoice Number</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <input
                                            type="text"
                                            v-model="formData.invoiceNum"
                                            id="invoice_num"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.invoiceNum"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.invoiceNum }}
                                        </p>
                                    </div>


                                    <!--                Invoice Status                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="Status"
                                            class="font-semibold"
                                        >Invoice Status</label
                                        >
                                        <span class="text-sm text-red-500">* </span>


                                        <label class="label cursor-pointer">
                                            <span class="label-text">Sent</span>
                                            <input
                                                type="radio"
                                                v-model="formData.Status"
                                                class="bg-gray-100 checked:bg-black"
                                                value="Sent"
                                                checked
                                            />
                                        </label>


                                        <label class="label cursor-pointer">
                                            <span class="label-text">Paid</span>
                                            <input
                                                type="radio"
                                                v-model="formData.Status"
                                                class="bg-gray-100 checked:bg-black"
                                                value="Paid"
                                            />
                                        </label>


                                        <label class="label cursor-pointer">
                                            <span class="label-text">Overdue</span>
                                            <input
                                                type="radio"
                                                v-model="formData.Status"
                                                class="bg-gray-100 checked:bg-black"
                                                value="Overdue"
                                            />
                                        </label>



                                        <p
                                            v-if="formData.errors.Status"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.Status }}
                                        </p>
                                    </div>



                                    <!--                Issue Date                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="issue_date"
                                            class="font-semibold"
                                        >Issue Date</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <VueDatePicker v-model="formData.issueDate" month-name-format="long" :enable-time-picker="false" placeholder="Select Date" :format="format" model-type="dd/MM/yyyy" />
                                        <p
                                            v-if="formData.errors.issueDate"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.issueDate }}
                                        </p>
                                    </div>


                                    <!--                Due Date                    -->

                                    <div
                                        class="md:col-span-5">
                                        <label
                                            for="due_date"
                                            class="font-semibold"
                                        >Due Date</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <VueDatePicker v-model="formData.dueDate" month-name-format="long" :enable-time-picker="false" placeholder="Select Date" :format="format" model-type="dd/MM/yyyy" />

                                        <p
                                            v-if="formData.errors.dueDate"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.dueDate }}
                                        </p>
                                    </div>



                                    <!--                Receiver  Name                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="receiver_name"
                                            class="font-semibold"
                                        >Receiver Name</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <input
                                            type="text"
                                            v-model="formData.billedToEst"
                                            id="receiver_name"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.billedToEst"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.billedToEst }}
                                        </p>
                                    </div>



                                    <!--                Receiver Address                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="receiver_address"
                                            class="font-semibold"
                                        >Receiver Address</label
                                        >
                                        <input
                                            type="text"
                                            v-model="formData.billedToAddress"
                                            id="receiver_address"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.billedToAddress"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.billedToAddress }}
                                        </p>
                                    </div>


                                    <!--                Receiver Email                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="receiver_email"
                                            class="font-semibold"
                                        >Receiver Email</label
                                        >
                                        <input
                                            type="text"
                                            v-model="formData.billedToEmail"
                                            id="receiver_email"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.billedToEmail"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.billedToEmail }}
                                        </p>
                                    </div>


                                    <!--                Currency                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="currency"
                                            class="font-semibold"
                                        >Currency</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <select
                                            class="select w-full"
                                            id="currency"
                                            v-model="formData.currency"
                                        >
                                            <option
                                                disabled
                                                selected
                                                class="text-black"
                                                value=""
                                            >
                                                Select Currency
                                            </option>
                                            <option value="USD">United States Dollar (USD)</option>
                                            <option value="EUR">Euro (EUR)</option>
                                            <option value="JPY">Japanese Yen (JPY)</option>
                                            <option value="GBP">British Pound (GBP)</option>
                                            <option value="AUD">Australian Dollar (AUD)</option>
                                            <option value="CAD">Canadian Dollar (CAD)</option>
                                            <option value="CHF">Swiss Franc (CHF)</option>
                                            <option value="CNY">Chinese Yuan (CNY)</option>
                                            <option value="SEK">Swedish Krona (SEK)</option>
                                            <option value="NZD">New Zealand Dollar (NZD)</option>

                                        </select>

                                        <p
                                            v-if="formData.errors.currency"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.currency }}
                                        </p>
                                    </div>



                                    <!--                Payment Method                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="paymentMethod"
                                            class="font-semibold"
                                        >Payment Method</label
                                        >
                                        <span class="text-sm text-red-500">* </span>


                                        <label class="label cursor-pointer">
                                            <span class="label-text">Credit Card</span>
                                            <input
                                                type="radio"
                                                v-model="formData.paymentMethod"
                                                class="bg-gray-100 checked:bg-black"
                                                value="Credit Card"
                                                checked
                                            />
                                        </label>


                                        <label class="label cursor-pointer">
                                            <span class="label-text">Wire Transfer</span>
                                            <input
                                                type="radio"
                                                v-model="formData.paymentMethod"
                                                class="bg-gray-100 checked:bg-black"
                                                value="Wire Transfer"
                                            />
                                        </label>


                                        <label class="label cursor-pointer">
                                            <span class="label-text">Cash</span>
                                            <input
                                                type="radio"
                                                v-model="formData.paymentMethod"
                                                class="bg-gray-100 checked:bg-black"
                                                value="Cash"
                                            />
                                        </label>



                                        <p
                                            v-if="formData.errors.paymentMethod"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.paymentMethod }}
                                        </p>
                                    </div>




                                    <!--                Num of items                    -->

                                    <div class="md:col-span-5 grid grid-cols-2 gap-4">
                                        <div>
                                        <label
                                            for="itemsNum"
                                            class="font-semibold"
                                        >Number of Items</label
                                        >
                                        <span class="text-sm text-red-500">* </span>
                                        <p class="text-sm text-gray-600 mt-2">Increase to add items, decrease to delete</p>



                                        <input
                                            type="number"
                                            min="1"
                                            step="1"
                                            v-model="formData.itemsNum"
                                            id="itemsNum"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.itemsNum"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.itemsNum }}
                                        </p>

                                        </div>

                                        <div class="flex items-center space-x-2 mt-16 md:mt-10 ">
                                            <button type="button" @click="formData.itemsNum++">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>

                                            </button>
                                            <button type="button" @click="formData.itemsNum--" class="border-l-2 border-gray-300 pl-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>

                                            </button>
                                        </div>

                                    </div>
                                    <p class="md:col-span-5 text-sm text-gray-600 mt-2">commas (,) and points (.) can be used to represent thousands and fractions respectively</p>

                                    <div class="md:col-span-5 grid grid-cols-2 gap-4" v-for="(item, index) in formData.items" :key="index">
                                        <div>
                                            <label :for="'item_description_' + index" class="font-semibold">Item ({{index+1}}) Description</label>
                                            <span class="text-sm text-red-500">* </span>

                                            <input type="text" v-model="item.description" :id="'item_description_' + index" class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full" />

                                            <p v-if="formData.errors['items.' + index + '.description']" class="text-sm text-red-500 font-semibold">
                                                {{formData.errors['items.' + index + '.description']}}
                                            </p>

                                        </div>
                                        <div>
                                            <label :for="'item_price_' + index" class="font-semibold">Item ({{index+1}}) Price</label>
                                            <span class="text-sm text-red-500">* </span>
                                            <input type="text" v-model="item.price" :id="'item_price_' + index" class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full" />
                                            <p v-if="formData.errors['items.' + index + '.price']" class="text-sm text-red-500 font-semibold">
                                                {{formData.errors['items.' + index + '.price']}}
                                            </p>

                                        </div>
                                    </div>


                                    <!--                Paper Size                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="paperSize"
                                            class="font-semibold"
                                        >Paper Size</label
                                        >
                                        <span class="text-sm text-red-500">* </span>

                                        <select
                                            class="select w-full"
                                            id="paperSize"
                                            v-model="formData.paperSize"
                                        >
                                            <option
                                                disabled
                                                selected
                                                class="text-black"
                                                value="a4"
                                            >
                                                Select Paper Size
                                            </option>
                                            <option value="A4">A4 (8.27 inches × 11.69 inches)</option>
                                            <option value="letter">Letter (8.5 inches × 11 inches)</option>
                                            <option value="legal">Legal (8.5 inches × 14 inches)</option>
                                        </select>

                                        <p
                                            v-if="formData.errors.paperSize"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.paperSize }}
                                        </p>
                                    </div>



                                    <div class="md:col-span-5 text-right flex space-x-4 justify-end mt-6">
                                        <div>
                                            <button
                                                class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded"
                                            >
                                                Preview & Download PDF
                                            </button>
                                        </div>

                                        <div>
                                            <button
                                                type="reset"
                                                @click="reset"
                                                class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded"
                                            >
                                                Clear All
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template end   -->
    </form>
</template>

<style scoped>

</style>
