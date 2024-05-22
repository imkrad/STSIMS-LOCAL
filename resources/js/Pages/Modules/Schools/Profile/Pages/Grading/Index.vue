<template>
    <b-col lg class="mt-3">
        <div class="input-group mb-3 mt-n1">
            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
            <input type="text" v-model="filter.keyword" placeholder="Search Grading" class="form-control" style="width: 30%;">
        </div>
    </b-col>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th style="width: 19%;">Grade</th>
                    <th style="width: 19%;" class="text-center">Upper Limit</th>
                    <th style="width: 19%;" class="text-center">Lower Limit</th>
                    <th style="width: 19%;" class="text-center">Failed</th>
                    <th style="width: 19%;" class="text-center">Incomplete</th>
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
    },
    
}
</script>