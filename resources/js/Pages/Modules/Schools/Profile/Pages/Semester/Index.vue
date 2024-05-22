<template>
    <b-col lg class="mt-3">
        <div class="input-group mb-3 mt-n1">
            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
            <input type="text" v-model="filter.keyword" placeholder="Search Semester" class="form-control" style="width: 30%;">
        </div>
    </b-col>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th style="width: 25%;">Academic Year</th>
                    <th style="width: 25%;" class="text-center">Semester</th>
                    <th style="width: 15%;" class="text-center">Start At</th>
                    <th style="width: 15%;" class="text-center">End At</th>
                    <th style="width: 15%;" class="text-center">Status</th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
        </table>
    </div>
</template>
<script>
export default {
    data(){
        return {
            filter: { 
                keyword: null
            }
        }
    }
}
</script>