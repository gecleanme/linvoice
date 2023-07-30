<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    logoURL: String,
    invoiceNum: String,
    issueDate: Date,
    dueDate: Date,
    companyName: String,
    address: String,
    billedToEst: String,
    billedToAddress: String,
    issuerPhone:String,
    issuerEmail:String,
    billedToEmail: String,
    paymentMethod: String,
    Status:String,
    items: Array,
    currency: String,
    invoiceTotal: Number


});

const showSuccess = ref(false);
</script>

<template>
    <div class="preview"
    v-show="!showSuccess"
    >
    <div class="alert alert-info bg-blue-400 mx-auto p-3 m-4 border-none w-1/2 space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>PDF file page will be of the desired size selected in the creation form</span>
        <a
            href="/download"

        >
            <button class="btn btn-outline text-black hover:text-white"
            @click="showSuccess = true"
            >Download</button>

        </a>
        </div>


        <div class="mt-4 flex lg:hidden alert alert-warning bg-orange-400 mx-auto p-3 m-4 border-none w-1/2 space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Switch to Desktop site for an accurate preview</span>
        </div>

    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img :src="logoURL" alt="" style="width: 100%; max-width: 300px"/>
                            </td>

                            <td>
                                Invoice #: {{ invoiceNum }}<br/>
                                Created: {{ issueDate }}<br/>
                                Due: {{ dueDate }} <br/>
                                Status: {{ Status }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ companyName }}<br/>
                                {{ address }} <br/> <br/>
                                Contact <br> {{issuerEmail}} <br/>
                                             {{issuerPhone}}
                            </td>

                            <td>
                                {{ billedToEst }}.<br/>
                                {{ billedToAddress }}<br/>
                                {{ billedToEmail }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>
                <td></td>

            </tr>

            <tr class="details">
                <td>{{ paymentMethod }}</td>
                <td></td>

            </tr>

            <tr class="heading">
                <td>Item</td>

                <td>Price</td>
            </tr>

            <tr class="item"
                v-for="item in items"
            >
                <td>{{ item['description'] }}</td>

                <td>{{ currency }} {{ item['price'] }}</td>
            </tr>


            <tr class="total">
                <td></td>

                <td>Total: {{ currency }} {{ invoiceTotal }}</td>
            </tr>
        </table>
    </div>
    </div>

    <div class="download-success"
    v-show="showSuccess"
    >
        <div class="flex items-center justify-center h-screen">
            <div>
                <div class="flex flex-col items-center space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 w-28 h-28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h1 class="text-4xl font-bold">Smells like fresh ink!</h1>
                    <p>Your PDF invoice has started downloading...</p>
                    <Link
                        :href="route('create')"

                        class="inline-flex items-center px-4 py-2 text-white bg-black rounded rounded-md focus:outline-none focus:ring">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-2 text-white fill-current" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                        </svg>
                        <span class="text-sm font-medium text-white">
                Create another
            </span>
                    </Link>
                </div>
            </div>
        </div>

    </div>

</template>

<style scoped>
body {
    font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    text-align: center;
    color: #777;
}

body h1 {
    font-weight: 300;
    margin-bottom: 0px;
    padding-bottom: 0px;
    color: #000;
}

body h3 {
    font-weight: 300;
    margin-top: 10px;
    margin-bottom: 20px;
    font-style: italic;
    color: #555;
}

body a {
    color: #06f;
}

.invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 30px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    font-size: 16px;
    line-height: 24px;
    font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    color: #555;
}

.invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
    border-collapse: collapse;
}

.invoice-box table td {
    padding: 5px;
    vertical-align: top;
}

.invoice-box table tr td:nth-child(2) {
    text-align: right;
}

.invoice-box table tr.top table td {
    padding-bottom: 20px;
}

.invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
}

.invoice-box table tr.information table td {
    padding-bottom: 40px;
}

.invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
}

.invoice-box table tr.details td {
    padding-bottom: 20px;
}

.invoice-box table tr.item td {
    border-bottom: 1px solid #eee;
}

.invoice-box table tr.item.last td {
    border-bottom: none;
}

.invoice-box table tr.total td:nth-child(2) {
    border-top: 2px solid #eee;
    font-weight: bold;
}

@media only screen and (max-width: 600px) {
    .invoice-box table tr.top table td {
        width: 100%;
        display: block;
        text-align: center;
    }

    .invoice-box table tr.information table td {
        width: 100%;
        display: block;
        text-align: center;
    }
}
</style>
