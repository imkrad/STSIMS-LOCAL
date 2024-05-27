<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" style="--vz-modal-width: 600px;" title="Create Reimbursement" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="12" class="mt-4">
                    <Search @clear="clear" @set="set"/>
                </BCol>
            </BRow>
            <BRow class="g-3" v-if="reimbursement.scholar">
                <BCol lg="12" class="mt-n1">
                    <InputLabel for="name" value="Semester" :message="form.errors.semester_id"/>
                    <Multiselect class="form-control"
                    placeholder="Select Year" label="academic_year" trackBy="academic_year"
                    :close-on-select="true" 
                    v-model="reimbursement.semester"
                    :searchable="true" :options="semesters" />
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel for="name" value="Privilege" :message="form.errors.start_at"/>
                    <Multiselect class="form-control"
                    placeholder="Select Privilege" label="name" trackBy="name"
                    :close-on-select="true" v-model="reimbursement.privilege"
                    :searchable="true" :options="privileges" />
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel for="name" value="Amount" :message="form.errors.end_at"/>
                    <Amount @amount="amount" ref="testing" :readonly="false"/>
                </BCol>
                <BCol lg="12" class="mt-1">
                    <InputLabel for="name" value="Remarks"/>
                    <TextInput id="name" v-model="reimbursement.remarks" type="text" class="form-control" :light="true"/>
                </BCol>
                <BCol lg="12" class="mt-1">
                    <input multiple class="mt-2 mb-1" type="file" :class="[($page.props.errors['files.'+0]) ? 'text-danger' : '']" @change="uploadFieldChange">
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-3 mb-2"/></BCol>
            </BRow>
        </form>
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import Search from '../Components/Search.vue';
import Multiselect from "@vueform/multiselect";
import Textarea from '@/Shared/Components/Forms/Textarea.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Amount from "@/Shared/Components/Forms/Amount.vue";
export default {
    components: { InputLabel, TextInput, Textarea, Amount, Multiselect, Search },
    props: ['privileges'],
    data(){
        return {
            currentUrl: window.location.origin,
            reimbursement: {
                privilege: '',
                semester: '',
                amount: '',
                scholar: '',
                remarks: '',
                files: []
            },
            form: { errors: []},
            semesters: [],
            showModal: false
        }
    },
    methods: { 
        show() {
            this.showModal = true;
        },
        set(data){
            this.reimbursement.scholar = data;
            this.semesters = data.semesters;
        },  
        amount(val){
            this.reimbursement.amount = val;
        },
        submit(){
            let data = new FormData();
            if(this.reimbursement.files.length > 0){
                for (var i = this.reimbursement.files.length - 1; i >= 0; i--) {
                    data.append('files[]', this.reimbursement.files[i]);
                }
            }else{
                data.append('files[]', '');
            }
            data.append('enrollment_id',(this.reimbursement.semester) ? this.reimbursement.semester : '');
            data.append('scholar_id',(this.reimbursement.scholar) ? this.reimbursement.scholar.id : '');
            data.append('benefit_id',(this.reimbursement.privilege) ? this.reimbursement.privilege : '');
            data.append('amount',this.reimbursement.amount);
            data.append('remarks',this.reimbursement.remarks);
            data.append('is_reimbursed',1);
            data.append('option','reimbursement');

            this.$inertia.post('/reimbursements', data, {
                preserveScroll: true,
                forceFormData: true,
                onSuccess: (response) => {
                    this.showModal = false;
                    this.clear();
                },
                onError: () => {
                    this.errors = this.$page.props.errors;
                }
            });
        },
        uploadFieldChange(e) {
            e.preventDefault();
            var files = e.target.files || e.dataTransfer.files;

            if (!files.length)
                return;
            for (var i = files.length - 1; i >= 0; i--) {
                this.reimbursement.files.push(files[i]);
            }
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        clear(){
            this.reimbursement.scholar = null;
            this.reimbursement.amount = '';
            this.reimbursement.files = [];
            this.reimbursement.remarks = '';
            this.reimbursement.semester = '';
            this.reimbursement.privilege = '';
            this.semesters = [];
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.showModal = false;
        }
    }
}
</script>