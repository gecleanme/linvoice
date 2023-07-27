<script setup>
import {useForm} from "@inertiajs/vue3";
import {computed, watch} from 'vue';


const format = (date) => {
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
}


const formData = useForm({
    companyName: null,
    logoURL: "https://karajkom.com/storage/logo/classic-theme_logo.png",
    invoiceNum:null,
    issueDate:null,
    dueDate: null,
    address:null,
    billedToEst:null,
    billedToName:null,
    billedToEmail:null,
    currency: "",
    itemsNum:1,
    items: Array.from({ length: 1 }, () => ({ description: '', price: null })),
    invoiceTotal:0,
    paymentMethod:"Credit Card",

});


watch(() => formData.itemsNum, (newVal, oldVal) => {
    if (newVal > oldVal) {
        // If the number of items has increased, add new items
        formData.items.push(...Array.from({ length: newVal - oldVal }, () => ({ description: '', price: null })));
    } else {
        // If the number of items has decreased, remove items from the end of the array
        formData.items.splice(newVal);
    }
});


const total = computed(() => formData.items.reduce((sum, item) => sum + Number(item.price), 0));

watch(total, (newTotal) => {
    formData.invoiceTotal = newTotal;
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
                        Create a PDF
                    </h2>

                    <div
                        class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6"
                    >
                        <div
                            class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3"
                        >
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">
                                    PDF Details
                                </p>
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

                                    <!-- Establishment name  -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="company_name"
                                            class="font-semibold"
                                        >Establishment/Biller Name</label
                                        >
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
                                        >Establishment / Biller Address</label
                                        >
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

                                    <!--                Invoice Number                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="invoice_num"
                                            class="font-semibold"
                                        >Invoice Number</label
                                        >
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


                                    <!--                Issue Date                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="issue_date"
                                            class="font-semibold"
                                        >Issue Date</label
                                        >
                                        <VueDatePicker v-model="formData.issueDate" month-name-format="long" :enable-time-picker="false" placeholder="Select Date" :format="format" model-type="dd/MM/yyyy" />
                                        <p
                                            v-if="formData.errors.issueDate"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.issueDate }}
                                        </p>
                                    </div>


                                    <!--                Due Date                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="due_date"
                                            class="font-semibold"
                                        >Due Date</label
                                        >
                                        <VueDatePicker v-model="formData.dueDate" month-name-format="long" :enable-time-picker="false" placeholder="Select Date" :format="format" model-type="dd/MM/yyyy" />

                                        <p
                                            v-if="formData.errors.dueDate"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.dueDate }}
                                        </p>
                                    </div>



                                    <!--                Billed to Establishment Name                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="billed_to_est"
                                            class="font-semibold"
                                        >Billed to Establishment Name</label
                                        >
                                        <input
                                            type="text"
                                            v-model="formData.billedToEst"
                                            id="billed_to_est"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.billedToEst"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.billedToEst }}
                                        </p>
                                    </div>



                                    <!--                Billed to Address                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="billed_to_add"
                                            class="font-semibold"
                                        >Billed to Address</label
                                        >
                                        <input
                                            type="text"
                                            v-model="formData.billedToName"
                                            id="billed_to_add"
                                            class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full"
                                        />
                                        <p
                                            v-if="formData.errors.billedToName"
                                            class="text-sm text-red-500 font-semibold"
                                        >
                                            {{ formData.errors.billedToName }}
                                        </p>
                                    </div>


                                    <!--                Billed to Email                    -->

                                    <div class="md:col-span-5">
                                        <label
                                            for="billed_to_mail"
                                            class="font-semibold"
                                        >Billed to Mail</label
                                        >
                                        <input
                                            type="text"
                                            v-model="formData.billedToEmail"
                                            id="billed_to_mail"
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

                                    <div class="md:col-span-5">
                                        <label
                                            for="itemsNum"
                                            class="font-semibold"
                                        >Number of Items</label
                                        >
                                        <input
                                            type="number"
                                            min="1"
                                            step="1"
                                            placeholder="Max of 5"
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

                                    <div class="md:col-span-5 grid grid-cols-2 gap-4" v-for="(item, index) in formData.items" :key="index">
                                        <div>
                                            <label :for="'item_description_' + index" class="font-semibold">Item ({{index+1}}) Description</label>
                                            <input type="text" v-model="item.description" :id="'item_description_' + index" class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full" />
                                        </div>
                                        <div>
                                            <label :for="'item_price_' + index" class="font-semibold">Item ({{index+1}}) Price</label>
                                            <input type="text" v-model="item.price" :id="'item_price_' + index" class="h-10 outline-white border border-gray-300 mt-1 rounded px-4 w-full" />
                                        </div>
                                    </div>


                                    <div class="md:col-span-5 text-right">
                                        <div class="inline-flex items-end">
                                            <button
                                                class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded"
                                            >
                                                Create PDF
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
