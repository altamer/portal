<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-11">
                <b-tabs>
                    <!--
                    <div class="card">
                        <b-tab title="Ostutellimused" active>
                            <div class="card-header">Ostutellimused</div>
                            <div><Purchase /></div>
                            <div class="card-body">
                                <label for="load">Truck max load (From 1000 to 8000 kg): </label>
                                <input type="number" id="load" name="truck_load" ref="myTestField" required>
                                <button type="button" class="btn btn-success" @click="runCalculate()">Calculate</button>
                            </div>

                            
                        </b-tab>
                    </div>
                    -->

                    <b-tab title="Kindlustused">

                        <div class="card">
                            <div class="card-header">Kindlustused</div>
                            <div><InsuranceComponent /></div>
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
import Purchase from './Purchase'
import InsuranceComponent from './InsuranceComponent'



export default {
  name: 'App',
  components: {

    InsuranceComponent,
    Purchase    
  }
}

</script>