<template>
<div class="p-4 d-flex flex-column h-100" style="overflow: auto;">
    <h6 class="fs-11 text-muted text-uppercase mb-3 mt-0">SCHOLARS ENROLLED</h6>
    <div class="d-flex align-items-center">
        <div class="flex-shrink-0">
            <i class="ri-database-2-line fs-17"></i>
        </div>
        <div class="flex-grow-1 ms-3 overflow-hidden">
            <b-progress class="animated-progress progress-sm mb-2" :max="statistics.total">
                <b-progress-bar :value="statistics.ongoing" variant="primary" />
            </b-progress>
            <span class="text-muted fs-12 d-block text-truncate"><b>{{statistics.ongoing}}</b> out of <b>{{statistics.total}}</b> ongoing scholars are enrolled.</span>
        </div>
    </div>
    <hr class="text-muted"/>
    <h5 class="fs-12 text-uppercase text-muted">SCHOLAR PROGRESS</h5>
    <div class="table-responsive">
        <table class="table table-borderless table-sm table-centered align-middle table-nowrap">
            <tbody class="border-0">
                <tr v-for="(count,index) in statistics.progress" v-bind:key="index">
                    <td>
                        <h4 class="text-truncate fs-13 fs-medium mb-0">
                            <i class="ri-stop-fill align-middle fs-18 me-2" :class="colors[index]"></i>{{options[index]}}
                        </h4>
                    </td>
                    <td class="text-end">
                        <p class="fw-bold fs-12 mb-0" :class="colors[index]">{{count}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr class="text-muted mt-n1 mb-3"/>
    <h5 class="fs-12 text-uppercase text-muted">SCHOLAR TYPE</h5>
    <div class="table-responsive">
        <table class="table table-borderless table-sm table-centered align-middle table-nowrap">
            <tbody class="border-0">
                <tr v-for="(count,index) in statistics.types" v-bind:key="index">
                    <td>
                        <h4 class="text-truncate fs-13 fs-medium mb-0"><i class="ri-checkbox-blank-circle-fill align-middle fs-14 me-2" :class="colors[index+3]"></i>{{options2[index]}}</h4>
                    </td>
                    <td class="text-end">
                        <p class="fw-bold mb-0 fs-12" :class="colors[(index+3)]">{{count}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr class="text-muted mt-n1"/>
    <ul class="list-group mb-4" style="cursor: pointer;">
        <li class="list-group-item fs-12" @click="print('awardees')"><i class="bx bxs-printer float-end fs-20 text-light align-middle me-2"></i><i class="bx fs-18 bxs-award text-warning align-middle me-2"></i>Graduates <span class="text-muted fs-11">(w/ Honor)</span> </li>
        <li class="list-group-item fs-12" @click="print('graduates')"><i class="bx bxs-printer float-end fs-20 text-light align-middle me-2"></i><i class="bx fs-18 bxs-graduation text-warning align-middle me-2"></i>List of Graduates</li>
        <li class="list-group-item fs-12" @click="print('scholars')"><i class="bx bxs-printer float-end fs-20 text-light align-middle me-2"></i><i class="ri-team-fill fs-18 text-warning align-middle me-2"></i>List of Scholars</li>
    </ul>
    <div class="mt-auto">
        <b-row class="g-1">
            <b-col lg="4">
                <button @click="openDownload()" class="btn btn-soft-primary btn-sm w-100" type="button">
                    <div class="btn-content"> Download </div>
                </button>
            </b-col>
            <b-col lg="4">
                <button @click="openTruncate()" class="btn btn-soft-primary btn-sm w-100" type="button">
                    <div class="btn-content"> Truncate </div>
                </button>
            </b-col>
            <b-col lg="4">
                <button @click="openSync(1)" class="btn btn-primary btn-sm w-100" type="button">
                    <div class="btn-content"> Sync (<b>{{statistics.sync_count}}</b>)</div>
                </button>
            </b-col>
        </b-row>
    </div>
</div>
<Download ref="download" @info="refresh()"/>
<Sync ref="sync" @info="update()"/>
<Truncate ref="truncate" @info="refresh()"/>
</template>
<script>
import Sync from '../Modals/Sync.vue';
import Download from '../Modals/Download.vue';
import Truncate from '../Modals/Truncate.vue';
export default {
    components: { Download, Sync, Truncate },
    props: ['statistics'],
    data(){
        return {
            options: ['Ongoing Scholars','Graduated Scholars','Total Scholars'],
            options2: ['Undegraduate Scholarhip','Junior Level Science Scholarship'],
            colors: ['text-primary','text-info','text-success','text-warning','text-danger'],
        }
    },
    methods: {
        openDownload(){
            this.$refs.download.show();
        },
        openTruncate(){
            this.$refs.truncate.show();
        },
        openSync(count){
            this.$refs.sync.show(count);
        },
        refresh(){
            this.$emit('info',true);
        },
    }
}
</script>