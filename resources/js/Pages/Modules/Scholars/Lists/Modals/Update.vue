<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>
        <template v-slot:header>
            <h5 class="modal-title">Update Scholar</h5>
            <button @click="hide()" type="button" class="btn-close" aria-label="Close"></button>
        </template>

        <b-form class="customform mb-2 ms-2 me-2">
            <div class="row">
                <div class="col-md">
                    <div class="p-3 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <b-img class="img-thumbnail rounded-circle avatar-sm" :src="currentUrl+'/images/avatars/avatar.jpg'" data-holder-rendered="true"></b-img>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-13 mb-1 fw-bold text-primary">{{selected.profile.firstname}} {{selected.profile.lastname}}</h6>
                                <span :class="'badge bg-secondary bg-success'">Good Standing</span>
                            </div>
                        </div>
                    </div>
                    <hr class="text-muted border-dashed"/>
                    <div class="mt-n2">
                        <InputLabel for="name" value="Status" :message="form.errors.status_id"/>
                        <Multiselect class="form-control"
                        placeholder="Select Status" label="name" trackBy="name"
                        v-model="status" :close-on-select="true" 
                        :searchable="true" :options="statuses"/>
                    </div>
                </div>
            </div>
        </b-form>
        <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="save('ok')" variant="primary" :disabled="form.processing" block>Proceed</b-button>
        </template>
    </b-modal>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
export default {
    components : { Multiselect, InputLabel },
    props: ['statuses'],
    data(){
        return {
            currentUrl: window.location.origin,
            showModal: false,
            selected: { profile:{} },
            status: '',
            form: { errors: []},
            type: ''
        }
    },
    computed: {
        status_list : function() {
            return this.statuses.filter(x => x.type == 'Progress' || x.type == 'Ongoing');
        }
    },
    methods : {
        set(data,type){
            this.selected = data;
            this.type = type;
            this.showModal = true;
        },
        save(){
            this.form = this.$inertia.form({
                id: this.selected.id,
                status_id: this.status,
                is_synced: 0,
                option: 'scholar'
            })

            this.form.put('/scholars/lists/update',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('update',true);
                    this.hide();
                }
            });
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
