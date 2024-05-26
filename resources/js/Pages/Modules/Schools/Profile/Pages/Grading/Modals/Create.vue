<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Add Grading" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12">
                    <div>
                        <h6 class="mb-1">Prospectus</h6>
                        <p class="text-muted fs-11 mt-n1">A curriculum-focused prospectus details the academic programs offered.</p>
                    </div>
                    <div>
                        <BRow class="g-1">
                            <BCol lg="12"><hr class="text-muted mt-n1 mb-n4"/></BCol>
                            
                            <BCol lg="4" class="mt-1">
                                <InputLabel for="grade" value="Grade"/>
                                <TextInput id="grade" v-model="grade.grade" type="text" class="form-control" :light="true"/>
                            </BCol>
                            <BCol lg="4" class="mt-1">
                                <InputLabel for="upper" value="Upper limit"/>
                                <TextInput id="upper" v-model="grade.upper_limit" type="text" class="form-control" :light="true"/>
                            </BCol>
                            <BCol lg="4" class="mt-1">
                                <InputLabel for="lower" value="Lower limit"/>
                                <TextInput id="lower" v-model="grade.lower_limit" type="text" class="form-control" :light="true"/>
                            </BCol>
                            <div class="col-md-12 mt-3 mb-1" v-if="show_inc">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="grade.is_incomplete" id="gridCheck1"/>
                                    <label class="form-check-label" for="gridCheck1">Is Incomplete?</label>
                                </div>
                            </div>
                            <div class="col-md-12" :class="(grade.is_failed) ? 'mt-3 mb-1' : 'mt-0 mb-0' " v-if="show_f">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="grade.is_failed" id="gridCheck"/>
                                    <label class="form-check-label" for="gridCheck">Is a failing grade?</label>
                                </div>
                            </div>
                            
                            <BCol lg="12"><hr class="text-muted mt-3 mb-2"/></BCol>
                        </BRow>
                    </div>    
                </BCol>
            </BRow>
        </form>
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import Multiselect from "@vueform/multiselect";
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Textarea, Multiselect },
    props: ['terms','term'],
    data(){
        return {
            currentUrl: window.location.origin,
            grade: {
                id: '',
                grade: '',
                upper_limit: '',
                lower_limit: '',
                is_failed: false,
                is_incomplete: false,
            },
            show_f: true,
            show_inc: true,
            form: {},
            showModal: false
        }
    },
    watch : {
        'grade.is_incomplete'(){
            if(this.grade.is_incomplete){
                this.grade.is_failed = false;
                this.show_f = false;
            }else{
                this.show_f = true;
            }
        },
        'grade.is_failed'(){
            if(this.grade.is_failed){
                this.grade.is_incomplete = false;
                this.show_inc = false;
            }else{
                this.show_inc = true;
            }
        },
    },
    methods: { 
        show(id) {
            this.grade = {
                id: '',
                grade: '',
                upper_limit: '',
                lower_limit: '',
                is_failed: false,
                is_incomplete: false,
            };
            this.id = id;
            this.showModal = true;
        },
        submit(){
            this.form = this.$inertia.form({
                id: this.grade.id,
                school_id: (this.editable) ? this.grade.school_id : this.id,
                grade: this.grade.grade,
                upper_limit: this.grade.upper_limit,
                lower_limit: this.grade.lower_limit,
                is_incomplete: this.grade.is_incomplete,
                is_failed: this.grade.is_failed,
                editable: this.editable,
                type: 'grading'
            })

            this.form.post('/schools',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.grade = {
                id: '',
                grade: '',
                upper_limit: '',
                lower_limit: '',
                is_failed: false,
                is_incomplete: false,
            };
            this.showModal = false;
        }
    }
}
</script>