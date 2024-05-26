<template>
    <b-col lg class="mt-3">
        <div class="input-group mb-3 mt-n1">
            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
            <input type="text" v-model="filter.keyword" placeholder="Search Grading" class="form-control" style="width: 30%;">
            <b-button type="button" variant="primary" @click="openCreate()">
                <i class="ri-add-circle-fill align-bottom"></i>
            </b-button>
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
            <tbody>
                 <tr v-for="(grade, index) in gradings" v-bind:key="'a-'+index" class="mb-n4 text-center"  :class="[(!grade.is_active) ? 'table-warning' : '']">
                    <td> {{grade.grade}} <span v-if="grade.is_failed">/ Failed</span><span v-if="grade.is_incomplete">/ Incomplete</span></td>
                    <td>{{grade.upper_limit}}</td>
                    <td> {{grade.lower_limit}}</td> 
                    <td>
                        <span v-if="grade.is_failed" class="badge bg-success">True</span>
                        <span v-else class="badge bg-danger">False</span>
                    </td> 
                    <td>
                        <span v-if="grade.is_incomplete" class="badge bg-success">True</span>
                        <span v-else class="badge bg-danger">False</span>
                    </td> 
                    <td class="text-center" width="100px;">
                        <b-button @click="openEdit(grade)" variant="soft-warning" v-b-tooltip.hover title="Edit" class="edit-list btn-sm me-1"><i class="ri-pencil-line align-bottom"></i> </b-button>
                        <b-button @click="openDisable(grade)" variant="soft-danger" v-b-tooltip.hover title="Disable" class="edit-list btn-sm"><i class="ri-delete-bin-5-line align-bottom"></i> </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <Create ref="create"/>
</template>
<script>
import Create from './Modals/Create.vue';
export default {
    components: { Create },
    props: ['id','gradings'],
    data(){
        return {
            filter: { 
                keyword: null
            }
        }
    },
    methods: {
        openCreate(){
            this.$refs.create.show(this.id);
        }
    }
}
</script>