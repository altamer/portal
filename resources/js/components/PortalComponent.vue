<template>
<div>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <b-tabs>

                <b-tab title="Kontaktid">

                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3">
                                    <select id="sorteering" @change="exec">
                                        <option value="1">Sorteeri:</option>
                                        <option value="2">Kliendikoodi järgi (kasvavalt)</option>
                                        <option value="3">Kliendikoodi järgi (kahanevalt)</option>
                                        <option value="4">Perekonnanimi järgi (kasvavalt)</option>
                                        <option value="5">Perekonnanimi järgi (kahanevalt)</option>
                                    </select>
                                </div>
                                <div class="col-md-8"></div>

                                <div class="col-md-1"><i v-on:click="switchEditMode" style="font-size:24px" class="fa">&#xf044;</i></div>
                            </div>

                        </div>
                        <div>
                            <TableComponent ref="child"></TableComponent>
                        </div>
                        <div class="card-body">

                            <table class="table" id="inserthtml"></table>

                        </div>
                    </div>
                </b-tab>
            </b-tabs>
        </div>
    </div>
</div>
</template>

<script>
import TableComponent from './TableComponent';

export default {
    name: 'App',
    components: {

        TableComponent
    },
    methods: {

        exec(e) {
            this.$refs.child.handleChange(e) //execute the method belongs to the child component
        },
        switchEditMode() {
            this.$refs.child.changeEditMode();
        }
    }
}
</script>
