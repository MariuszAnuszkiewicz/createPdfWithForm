<template>
<div class="container">
    <div class="col-md-12 pb-4 pt-3 bg-warning">
        <div class="container col-md-6 mt-5">
            <div class="form-group text-center">
                <form method="POST" action="" @submit.prevent="generatePdf" id="form-select">
                    <div v-for="(value, key, index) in rows" v-if="index == increment" class="pt-0">
                        <div class="pt-2">
                            <label v-for="(val, index) in key" class="control-label"><strong>{{ val }}</strong></label>
                        </div>
                        <select @change="selectField($event)" v-model="selectedDynamically" class="form-control">
                            <option v-for="(val, index) in value" :value="val + ','" :key="index">{{ val }}</option>
                        </select>
                    </div>
                    <div v-if="increment > (length -1)" class="pt-2">
                        <button type="submit" name="get_pdf" class="btn btn-primary">Pobierz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import jsPDF from 'jspdf'
    export default {
        props: {
            rows: Object,
            length: Number
        },
        mounted() {
            console.log(this.rows),
            console.log(this.selectedOption),
            console.log(this.length)
        },
        data() {
            return {
                selectedDynamically: -1,
                selectedOption: [],
                increment: 0
            };
        },
        methods: {
            selectField: function(event){
                this.selectedOption.push(event.target.value);
                this.increment += 1;
            },
            generatePdf: function() {
                axios
                    .post("/createPdf", { selectedOption: this.selectedOption })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(e => {
                        console.error(e);
                    });
                const doc = new jsPDF();
                doc.text(this.selectedOption, 15, 15);
                doc.save("selected.pdf");
            }
        }
    }
</script>
