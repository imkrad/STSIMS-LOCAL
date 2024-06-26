<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Benefits" class="form-control" style="width: 55%;">
                <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button @click="openReimbursement" type="button" variant="primary">
                    <i class="ri-add-circle-fill align-bottom me-1"></i> Reimbursement
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th>Release Month</th>
                    <th width="30%" class="text-center">Receiver</th>
                    <th width="15%" class="text-center">Total</th>
                    <th width="20%" class="text-center">Added By</th>
                    <th width="20%" class="text-center">Released Date</th>
                    <th width="10%" class="text-center">Status</th>
                    <th width="5%"></th>
                </tr>
            </thead>
             <tbody>
                <tr v-for="(list,index) in lists" v-bind:key="index">
                    <td>
                        <h5 class="fs-13 mb-0 text-dark">{{list.month}}</h5>
                        <p class="fs-12 text-muted mb-0">Batch {{list.batch }}</p>
                    </td>
                    <td class="text-center">{{list.lists.length}} Scholar<span v-if="list.lists.length > 1">s</span></td>
                    <td class="text-center">{{ formatMoney(list.total) }}</td>
                    <td class="text-center">{{list.added_by.firstname}} {{list.added_by.lastname}}</td>
                    <td class="text-center">{{list.created_at}}</td>
                    <td class="text-center">
                        <span :class="'badge '+list.status.color">{{list.status.name}}</span>
                    </td>
                    <td class="text-end">
                        <b-button @click="openView(list)" variant="soft-info" v-b-tooltip.hover title="View" size="sm" class="edit-list me-1"><i class="ri-eye-fill align-bottom"></i> </b-button>
                        <b-button v-if="list.status.name != 'Released'" @click="openConfirmation(list)" variant="soft-success" v-b-tooltip.hover title="Mark as Completed" size="sm" class="edit-list"><i class="ri-checkbox-circle-fill align-bottom"></i> </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <View ref="view"/>
    <Confirm @update="fetch()" ref="confirm"/>
    <Reimbursement :privileges="privileges" ref="reimbursement"/>
</template>
<script>
import _ from 'lodash';
import View from "../Modals/Lists/View.vue";
import Confirm from '../Modals/Lists/Confirm.vue';
import Reimbursement from '../Modals/Reimbursement.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    props: ['privileges'],
    components: { Pagination, Confirm, View, Reimbursement },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
                status: null
            }
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url) {
            page_url = page_url || '/financial-benefits';
            axios.get(page_url, {
                params: {
                    keyword: this.filter.keyword,
                    status: this.filter.status,
                    counts: parseInt(((window.innerHeight-350)/56)),
                    option: 'lists'
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        openView(data){
            this.$refs.view.set(data);
        },
        openConfirmation(data){
            this.$refs.confirm.set(data);
        },
        openReimbursement(){
            this.$refs.reimbursement.show();
        },
        formatMoney: function formatMoney(value) {
            var val = (value / 1).toFixed(2).replace(',', '.');
            return '₱' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
    }
}
</script>