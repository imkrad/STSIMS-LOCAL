<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Qualifier" class="form-control" style="width: 40%;">
                <!-- <input type="text" v-model="filter.year" placeholder="Year Awarded" class="form-control" style="width: 30px;"> -->
                 <Multiselect class="form-control" style="width:5%"
                 placeholder="Select Type" label="name" trackBy="name"
                v-model="filter.type" :close-on-select="true" :canDeselect="false" :canClear="false"
                :searchable="false" :options="['From','To']" />
                <Multiselect class="form-control" style="width:8%"
                 placeholder="Select Status" label="name" trackBy="name"
                v-model="filter.status" :close-on-select="true" :canDeselect="false" :canClear="false"
                :searchable="false" :options="statuses" />
                <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="openFilter">
                    <i class="ri-filter-fill align-bottom me-1"></i> Filter
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th></th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 15%;" class="text-center">Address</th>
                    <th style="width: 15%;" class="text-center">Awarded Year</th>
                    <th style="width: 15%;" class="text-center">
                        <span v-if="filter.type == 'From'">Endorsed By</span>
                        <span v-else>Endorsed To</span>
                    </th>
                    <th style="width: 15%;" class="text-center">Status</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="list in lists" v-bind:key="list.id" :class="[(list.is_active == 0) ? 'table-warnings' : '']">
                    <td>
                        <div class="avatar-xs" v-if="list.profile.avatar == 'n/a'">
                            <span class="avatar-title rounded-circle">{{list.profile.lastname.charAt(0)}}</span>
                        </div>
                        <div v-else>
                            <img class="rounded-circle avatar-xs" :src="currentUrl+'/images/avatars/'+list.profile.avatar" alt="">
                        </div>
                    </td>
                    <td>
                        <h5 class="fs-13 mb-0">{{list.profile.lastname}}, {{list.profile.firstname}} {{list.profile.middlename[0]}}.</h5>
                        <p class="fs-11 text-muted mb-0">{{list.spas_id }}</p>
                    </td>
                    <td class="text-center">
                        <h5 class="fs-11 mb-0">{{list.address.name}}</h5>
                        <p class="fs-11 text-muted mb-0">
                            {{(list.address.province) ? list.address.province.name+',' : ''}}
                            {{(list.address.region) ? list.address.region.region : ''}}
                        </p>
                    </td>
                    <td class="text-center">{{list.qualified_year}}</td>
                    <td class="text-center">
                        <span v-if="filter.type == 'From'">{{list.endorsement.endorsedby.region}}</span>
                        <span v-else>{{list.endorsement.endorsedto.region}}</span>
                    </td>
                    <td class="text-center">
                        <span :class="'badge '+list.type.color+' '+list.type.others">{{list.type.name}}</span>
                    </td>
                    <td class="text-end">
                        <b-button variant="soft-primary" @click="openView(list)" v-b-tooltip.hover title="View" size="sm" class="edit-list"><i class="ri-eye-fill align-bottom"></i> </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="extractPageNumber" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <View @status="fetchUpdate()" ref="view"/>
</template>
<script>
import _ from 'lodash';
import View from '../Modals/View.vue';
import Multiselect from "@vueform/multiselect";
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Multiselect, View },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                subfilters: [],
                year: null,
                keyword: null,
                status: 14,
                sort: 'asc',
                type: 'From'
            },
            subfilters: [],
            flag: '',
            index: '',
            pageNo: null,
            statuses: []
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.year"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.status"(){
            this.fetch();
        },
        "filter.type"(){
            this.fetch();
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
            let info = {
                'keyword': this.filter.keyword,
                'status': (this.filter.status === '' || this.filter.status == null) ? '' : this.filter.status,
                'year': (this.filter.year === '' || this.filter.year == null) ? '' : this.filter.year,
                'counts': parseInt(((window.innerHeight-350)/56)),
                'sort': this.filter.sort
            };

            info = (Object.keys(info).length == 0) ? '-' : JSON.stringify(info);

            page_url = page_url || '/scholars/endorsements';
            axios.get(page_url, {
                params: {
                    info: info,
                    subfilters: this.subfilters,
                    type: this.filter.type,
                    option: 'lists',
                    page: this.pageNo
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        fetchUpdate(){
            this.fetch();
            this.$emit('status',true);
        },
        openFilter(){
            this.$refs.filter.show();
        },
        openAdd(data,type,index){
            this.index = index;
            this.flag = type;
            this.$refs.add.show(data);
        },
        openEndorse(data,type,index){
            this.index = index;
            this.flag = type;
            this.$refs.endorse.show(data);
        },
        openUpdate(data,type,index){
            this.index = index;
            this.flag = type;
            this.$refs.update.show(data,type);
        },
        openEdit(data,type,index){
            this.index = index;
            this.flag = type;
            this.$refs.edit.show(data,type);
        },
        openView(data){
            this.$refs.view.show(data);
        },
        subfilter(list){
            this.subfilters = list;
            this.subfilters = (Object.keys(this.subfilters).length == 0) ? '-' : JSON.stringify(this.subfilters);
            this.fetch();
        },
        fetchUpdate(){
            this.fetch();
            this.$emit('status',true);
        },
        extractPageNumber(page_url) {
            this.pageNo = null;
            const nextUrl = page_url;
            const regex = /page=(\d+)/;
            const match = nextUrl.match(regex);

            if (match) {
                this.pageNo = match[1];
            } else {
                this.pageNo = null;
            }
            this.fetch();
        },
    }
}
</script>