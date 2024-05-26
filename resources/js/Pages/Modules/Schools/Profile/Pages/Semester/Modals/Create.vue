<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" title="Create Semester" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow>
                <BCol lg="12">
                    <div>
                        <h6 class="mb-1">Prospectus</h6>
                        <p class="text-muted fs-11 mt-n1">A curriculum-focused prospectus details the academic programs offered.</p>
                    </div>
                    <div>
                        <BRow class="g-3">
                            <BCol lg="12"><hr class="text-muted mt-n1 mb-n4"/></BCol>
                            <BCol lg="6" class="mt-1">
                                <InputLabel for="name" value="School Year" :message="form.errors.year"/>
                                   <Multiselect class="form-control"
                                    placeholder="Select Year" label="name" trackBy="name"
                                    v-model="semester.from" :close-on-select="true" 
                                    :searchable="true" :options="years" />
                            </BCol>
                            <BCol lg="6" class="mt-1">
                                <InputLabel for="name" value="Academic Year"/>
                                <TextInput id="name" v-model="academic_year" type="text" class="form-control" readonly :light="true"/>
                            </BCol>
                            <BCol lg="12" class="mt-1">
                                <InputLabel for="name" value="Semester" :message="form.errors.semester_id"/>
                                   <Multiselect class="form-control"
                                    placeholder="Select Year" label="name" trackBy="name"
                                    v-model="semester.semester" :close-on-select="true" 
                                    :searchable="true" :options="semesters" />
                            </BCol>
                            <BCol lg="6" class="mt-1">
                                <InputLabel for="name" value="Start At" :message="form.errors.start_at"/>
                                <Multiselect class="form-control"
                                placeholder="Select Year" label="name" trackBy="name"
                                v-model="semester.start" :close-on-select="true" 
                                :searchable="true" :options="starts" />
                            </BCol>
                            <BCol lg="6" class="mt-1">
                                <InputLabel for="name" value="End At" :message="form.errors.end_at"/>
                                <Multiselect class="form-control"
                                placeholder="Select Year" label="name" trackBy="name"
                                v-model="semester.end" :close-on-select="true" 
                                :searchable="true" :options="starts" />
                            </BCol>
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
            semester: {
                from: '',
                to: '',
                start: '',
                end: '',
                year: '',
                semester: {}
            },
            form: { errors: []},
            id: null,
            showModal: false
        }
    },
    computed : {
        academic_year : function(){
            if(this.semester.from){
                this.year = this.semester.from;
                return this.year+'-'+ (Number(this.year)+1);
            }else{
                return '';
            }
        },
        starts : function(){
            const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            const monthsArray = [];
            if(this.semester.from){
                for(let a = 0; a <= 1; a++){
                    const y = this.semester.from + a;
                    months.forEach((item) => {
                        monthsArray.push(item+' '+y);
                    });
                }
                return monthsArray;
            }else{
                return [];
            }
        },
        semesters : function() {
            return this.terms.filter(x => x.classification === this.term);
        },
        years: function(){
            const currentYear = new Date().getFullYear();
            const startYear = 2000;
            const yearsArray = [];

            for(let year = currentYear; year >= startYear; year--){
                yearsArray.push(year);
            }
            return yearsArray;
        }
    },
    methods: { 
        show(id) {
            this.id = id;
            this.showModal = true;
        },
        submit(){
            this.form = this.$inertia.form({
                school_id: this.id,
                academic_year: (this.semester.from) ? this.academic_year : '',
                start_at: (this.semester.start != '') ? this.semester.start : '',
                end_at: (this.semester.end != '') ? this.semester.end : '',
                year: this.year,
                semester_id: this.semester.semester,
                editable: false,
                type: 'semester'
            })

            this.form.post('/schools',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('new',true);
                    this.hide();
                },
            });
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.showModal = false;
        }
    }
}
</script>