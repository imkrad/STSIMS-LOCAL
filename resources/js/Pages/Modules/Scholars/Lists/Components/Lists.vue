<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Scholar" class="form-control" style="width: 55%;">
                <!-- <select v-model="filter.status" @change="fetch()" class="form-select" id="inputGroupSelect01">
                    <option :value="null" selected>Select Status</option>
                    <option :value="list.value" v-for="list in dropdowns.statuses" v-bind:key="list.id">{{list.name}}</option>
                </select>
                <select v-model="filter.laboratory" @change="fetch()" class="form-select" id="inputGroupSelect01" style="width: 140px;">
                    <option :value="null" selected>Select Laboratory</option>
                    <option :value="list.value" v-for="list in dropdowns.laboratories" v-bind:key="list.id">{{list.name}}</option>
                </select> -->
                 <span @click="openFilter" class="input-group-text" v-b-tooltip.hover title="Filter" style="cursor: pointer;"> 
                    <i class="ri-filter-fill search-icon"></i>
                </span>
                <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="openCreate">
                    <i class="ri-add-circle-fill align-bottom me-1"></i> Create
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
                    <th style="width: 15%;" class="text-center">Program</th>
                    <th style="width: 15%;" class="text-center">Awarded Year</th>
                    <th style="width: 15%;" class="text-center">School</th>
                    <th style="width: 15%;" class="text-center">Status</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user,index) in lists" v-bind:key="index" :class="[(user.is_completed == 0) ? 'table-warnings' : '']">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-n1 ms-n2">
                                <img :src="currentUrl+'/images/avatars/'+user.profile.avatar" class="rounded-circle avatar-xs" alt="">
                                <span class="user-status" :style="(user.profile.sex == 'Male') ? 'background-color: #5cb0e5;' : 'background-color: #e55c7f;'"></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <h5 class="fs-12 mb-0 fw-semibold">{{user.profile.name}}</h5>
                        <p class="fs-11 text-muted mb-0">{{(user.spas_id) ? user.spas_id : user.stsims_id}}</p>
                    </td>
                    <td class="fs-12 text-center">{{user.program}}</td>
                    <td class="fs-12 text-center">{{user.awarded_year}}</td>
                    <td class="text-center">
                        <p class="fs-12 mb-n1 text-dark">{{(user.education.school instanceof Object) ? user.education.school.name : user.education.school}}</p>
                        <p class="fs-12 text-muted mb-0">{{(user.education.course instanceof Object) ? user.education.course.name : user.education.course}}</p>
                    </td>
                    <td class="text-center">
                        <span :class="'badge '+user.status.color+' '+user.status.others">{{user.status.name}}</span>
                    </td>
                    <td class="text-end">
                        <!-- <b-button v-if="user.user == null" @click="authenticate(user)" variant="soft-primary" v-b-tooltip.hover title="Create Scholar Account" size="sm" class="edit-list me-1"><i class="ri-user-add-fill align-bottom"></i> </b-button> -->
                        <b-button @click="openUpdate(user,index)" variant="soft-warning" v-b-tooltip.hover title="Update Status" size="sm" class="remove-list me-1"><i class="ri-pencil-fill align-bottom"></i></b-button>
                        <b-button @click="openView(user)" variant="soft-info" v-b-tooltip.hover title="View Profile" size="sm" class="remove-list me-n2"><i class="ri-eye-fill align-bottom"></i></b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Filter :dropdowns="dropdowns" @status="subfilter" ref="filter"/>
    <View ref="view"/>
    <Update :statuses="dropdowns.statuses" @update="updateScholar" ref="update"/>
</template>
<script>
import _ from 'lodash';
import View from '../Modals/View.vue';
import Filter from '../Modals/Filter.vue';
import Update from '../Modals/Update.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Filter, View, Update },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter : {
                keyword: null,
                sort: 'asc',
                type: null,
                subfilters: [],
                year: null,
            },
            subfilters: [],
            index: null
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.year"(newVal){
            this.checkSearchStr(newVal)
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
                'year': (this.filter.year === '' || this.filter.year == null) ? '' : this.filter.year,
                'counts': parseInt(((window.innerHeight-350)/56)),
                'sort': this.filter.sort,
                'type': this.filter.type,
            };

            info = (Object.keys(info).length == 0) ? '-' : JSON.stringify(info);

            page_url = page_url || '/scholars/lists';
            axios.get(page_url, {
                params: {
                    info: info,
                    subfilters: this.subfilters,
                    option: 'lists',
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        openFilter(){
            this.$refs.filter.show();
        },
        openView(data){
            this.$refs.view.show(data);
        },
        openUpdate(data,index){
            this.index = index;
            this.$refs.update.set(data);
        },
        updateScholar(){
            this.lists[this.index] = this.$page.props.flash.data.data;
        },
        subfilter(list){
            this.subfilters = list;
            this.subfilters = (Object.keys(this.subfilters).length == 0) ? '-' : JSON.stringify(this.subfilters);
            this.fetch();
        },
    }
}
</script>