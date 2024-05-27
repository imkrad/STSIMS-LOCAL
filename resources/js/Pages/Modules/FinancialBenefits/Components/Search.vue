<template>
    <form class="app-search d-none d-md-block" style="margin-top: -25px;">
        <div class="position-relative">
            <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" />
            <span class="mdi mdi-magnify search-widget-icon"></span>
            <span @click="clear()" class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
        </div>
        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
            <SimpleBar data-simplebar style="max-height: height: calc(100vh/2 - 326px)">
                <div class="notification-list">
                    <b-link @click="choose(list)" v-for="(list, index) of names" :key="index" class="d-flex dropdown-item notify-item py-2">
                        <img :src="currentUrl+'/images/avatars/'+list.profile.avatar" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                        <div class="flex-1">
                            <h6 class="m-0">{{ list.profile.name}}</h6>
                            <span class="fs-11 mb-0 text-muted">{{list.program.name}}</span>
                        </div>
                    </b-link>
                </div>
            </SimpleBar>
        </div>
    </form>
    <ul class="list-unstyled mb-0 vstack gap-3 mb-3" v-if="reimbursement.scholar">
        <li>
            <hr class="mt-0 text-muted"/>
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img :src="currentUrl+'/images/avatars/'+reimbursement.scholar.profile.avatar" alt="" class="avatar-sm rounded">
                </div>
                <div class="flex-grow-1 ms-3">
                    <button @click="clear()" class="btn btn-outline-danger btn-sm bg-gradient waves-effect waves-light float-end mt-n1" type="button">
                        <div class="btn-content"> Change scholar</div>
                    </button>
                    <h6 class="fs-14 mb-1 text-primary">{{reimbursement.scholar.profile.name}}</h6>
                    <span :class="'badge bg-secondary bg-'+reimbursement.scholar.status.color">{{reimbursement.scholar.status.name}}</span>
                </div>
            </div>
            <hr class="mt-3 text-muted"/>
        </li>
    </ul>
</template>
<script>
import _ from 'lodash';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            names: [],
            reimbursement: { scholar: null},
            scholar: {education: {school: {} ,course:{}, subcourse:{}}},
            keyword: null
        }
    },
    mounted() {
        this.isCustomDropdown();
    },
    methods: {
        checkSearchStr: _.debounce(function (string) {
            this.keyword = string;
            this.search();
        }, 500),
        search(){
            axios.get('/reimbursements', {
                params: {
                    keyword: this.keyword,
                    option: 'search'
                }
            })
            .then(response => {
                if(response){ 
                    this.scholar = {};
                    this.names = response.data.data; 
                }
            })
            .catch(err => console.log(err));
        },
        choose(data){
            this.reimbursement.scholar = data;
            this.semesters = data.semesters;
            this.$emit('set',data);
        },
        clear(){
            var searchInput = document.getElementById("search-options");
            searchInput.value = '';
            this.reimbursement.scholar = '';
            this.isCustomDropdown();
            this.$emit('clear',true);
        },
        isCustomDropdown() {
            var searchOptions = document.getElementById("search-close-options");
            var dropdown = document.getElementById("search-dropdown");
            var searchInput = document.getElementById("search-options");

            searchInput.addEventListener("focus", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchInput.addEventListener("keyup", () => {
                var inputLength = searchInput.value.length;
                if (inputLength > 0) {
                    dropdown.classList.add("show");
                    searchOptions.classList.remove("d-none");
                    this.checkSearchStr(searchInput.value);
                } else {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });

            searchOptions.addEventListener("click", () => {
                searchInput.value = "";
                dropdown.classList.remove("show");
                searchOptions.classList.add("d-none");
            });

            document.body.addEventListener("click", (e) => {
                if (e.target.getAttribute("id") !== "search-options") {
                    dropdown.classList.remove("show");
                    searchOptions.classList.add("d-none");
                }
            });
        }
    }
}
</script>
<style>
    .dropdown-menu-lg {
        width: 89.1%;
    }
</style>