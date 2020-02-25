<template>
        <div class="flex-center position-ref full-height">
            <div class="content">
               

                    <div class="card-body">

                        <div class="row mb-4">
                           <div class="col-md-6">   
                              <input class="form-control" v-model="search" type="text" placeholder="Otsi..." aria-label="Search">
                           </div> 
                           <div class="col-md-3">  
                              <label class="checkbox-inline"><input type="checkbox" v-model="expiredchecked" v-on:click="expiredClicked" value="">Näita aegunud</label>
                           </div> 
                           <div class="col-md-3">  
                              <label class="checkbox-inline"><input type="checkbox" v-model="hiddenchecked" v-on:click="hiddenClicked" value="">Näita kustutatud</label>
                           </div> 
                        </div>    

                       <div class="row mb-4">                        
                                <div class="col-md-3" v-on:click="showRowMachine">+Uus Masin</div>  <div class="col-md-3" v-on:click="showRowInsurance">  +Uus Kindlustus</div>                       
                        </div>                        

                        <div id="addmachinediv" style="display:none">                        

                            <div class="row mb-4">
                                
                                <div class="col-md-12">
                                   <label for="vin">Masin:</label>
                                   <input type="text" v-model="machine" id="machine" class="form-control">                            
                                </div>
                                
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                   <label for="vin">Vin: </label>
                                   <input type="text" v-model="vin" id="vin" class="form-control">                            
                                </div>

                                <div class="col-md-6">
                                   <label for="vin">Aasta: </label>
                                   <input type="number" v-model="year" id="year" class="form-control">                            
                                </div>
                            </div>

                            <div class="row mb-4">
                                   <div class="col-md-6">
                                      <button type="button" class="btn btn-success" v-on:click="saveMachine">Lisa Masin</button>  
                                   </div>
                            </div>                         

                                                      
                            <div class="row mb-4">
                                <div v-if="errormachine != ''" class="alert alert-success" role="alert">
                                   {{errormachine}}
                                </div>
                            </div>                               

                        </div>                         

                        <div id="addinsurancediv" style="display:none">

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="masin">Masin: </label>
                                        <select v-model="optionmachine" class="form-control">
                                           <option v-for="item in list" :value="item.id">id: {{item.id}} / Vin: {{item.vin}} / Aasta: {{item.year}} / Masin: {{item.machine}}</option>
                                        </select>
                                </div> 
                            </div> 

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="vin">Tüüp: </label>
                                        <select v-model="option" class="form-control">
                                           <option value="kasko">Kasko</option>
                                           <option value="liiklus">Liiklus</option>
                                           <option value="uv">Ülevaatus</option>
                                        </select>
                                </div> 

                                <div class="col-md-6">
                                   <label for="load">Aegub: </label>
                                
                                   <datepicker id="datevalue" v-model="datesel"></datepicker>
                            
                                </div>                                     
                                
                            </div>                
                        
                            <div class="row mb-4">
                                   <div class="col-md-12">
                                <label for="load">Märkmed: </label>
                                
                                <textarea v-model="notessel" id="notestext" class="form-control" rows="3"></textarea>
                            
                                   </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                   <button type="button" class="btn btn-success" @click="saveInsurance">Lisa Kindlustus</button>
                                </div>
                            </div>  
                            
                            <div class="row mb-4">
                               <div v-if="errormes != ''" class="alert alert-success" role="alert">
                                  {{errormes}}
                               </div>                     
                            </div>

                        </div>

                        <table class="table">
                            
                                        <thead class="card-header">
                                            <tr>
                                                <th>Vin</th>
                                                <th>Aasta</th>
                                                 <th>Masin</th>
                                                 <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <template v-for="item in filteredList">   
                                            <tr v-bind:class="{'striked': item.active == '0', 'hidden': item.active == '0' && hiddenchecked  == false, 'hiddenshow': item.active == '0' && hiddenchecked  == true }" class="yellow">
                                                                                        
                                                <td><span v-if="item.editmode"><input v-on:blur="editmachine(item)" v-model="item.vin"/></span>
        <span @click="editmachine(item)" v-else>{{ item.vin }}</span></td>
                                                <td><span v-if="item.editmode"><input v-on:blur="editmachine(item)" v-model="item.year"/></span>
        <span @click="editmachine(item)" v-else>{{ item.year }}</span></td>
                                                <td><span v-if="item.editmode"><input v-on:blur="editmachine(item)" v-model="item.machine"/></span>
        <span @click="editmachine(item)" v-else>{{ item.machine }}</span></td>
                                                <td v-on:dblclick="doubleclickedrowmachine(item.id, item.active)">X</td>
                                                
                                            </tr>

                                            <tr class="card-header">
                                                <th>Tüüp</th>
                                                <th>Aegub</th>
                                                <th>Märkmed</th>
                                                <th>Delete</th>
                                            </tr>

                                            <template v-for="item2 in filterInsuranceByMachine(item['id'])"> 
                                            <tr v-bind:class="{'striked': item2.active == '0', 'hidden': item2.active == '0' && hiddenchecked  == false, 'hiddenshow': item2.active == '0' && hiddenchecked  == true }" class="white">
                                                                                        
                                                <td><span v-if="item2.editmode"><select v-on:blur="editinsurance(item2)" v-model="item2.type" class="form-control">
                                           <option value="kasko">Kasko</option>
                                           <option value="liiklus">Liiklus</option>
                                           <option value="uv">Ülevaatus</option>
                                        </select></span><span @click="editinsurance(item2)" v-else>{{ item2.type }}</span></td>
                                                <td><span v-if="item2.editmode"><datepicker id="datevalue" v-on:blur="editinsurance(item2)" v-model="item2.duedate"></datepicker></span>
        <span @click="editinsurance(item2)" v-else>{{ item2.duedate }}</span></td>
                                                <td><span v-if="item2.editmode"><input v-on:blur="editinsurance(item2)" v-model="item2.notes"/></span>
        <span @click="editinsurance(item2)" v-else>{{ item2.notes }}</span></td>
                                                <td v-on:dblclick="doubleclickedrow(item2.id, item2.active)">X</td>
                                                
                                            </tr>
                                            </template>

                                          </template>                                            

                                        </tbody>
                                    </table>                             
                    </div>                
            </div>
        </div>
    </template>
    <script>
    import Datepicker from 'vuejs-datepicker';
    export default {
        mounted() {
                
                var ref = this;
                ref.refreshData();

            },
        components: {

    Datepicker  
  },
  computed: {
    filteredList() {     
      
      this.list  = this.list.filter(x => this.brr.indexOf(x.id) < 0);

      return this.list.filter(post => {
        return post.machine.toLowerCase().includes(this.search.toLowerCase()) || post.vin.toLowerCase().includes(this.search.toLowerCase()) 
      }) // end filter    
    
    } // end filtered list 

  },
        data(){
            return {
                image: '',
                success: '',
                errormes: '',
                errormachine: '',
                datesel: '',
                notessel: '',
                selectedDate: '',
                vin: '',
                year: '',
                machine: '',
                option: null,
                optionmachine: null,
                brr: [],
                list: [],
                list2: [],               
                id: null,
                item2: [],            
                machineid: null,
                targetId: null,
                clickedid: null,
                status: null,
                isActive: false,
                active_el:0,
                expiredchecked: false,
                hiddenchecked: false,
                search: '',
                editingstatus: false,
                editingstatusinsurance: false,
                editmode: false                
            }
        },        
        methods: {

            editmachine :function(obj){
        // this.$set(obj, 'editmode', true);
        this.editingstatus = !this.editingstatus;
        
        this.$set(obj, 'editmode', this.editingstatus);
        // alert("vin " + obj.vin);

        if(this.editingstatus == false) {
        axios.post(axios.defaults.baseURL + '/updatemachine',{id: obj.id, vin: obj.vin, year: obj.year, machine: obj.machine}).then(result => {
                                     
                           this.refreshData();
            })
        } // end if    
      }, editinsurance :function(obj){
        // this.$set(obj, 'editmode', true);
        this.editingstatusinsurance = !this.editingstatusinsurance;
        this.$set(obj, 'editmode', this.editingstatusinsurance);
        // alert("vin " + obj.vin);

        if(this.editingstatusinsurance == false) {
        axios.post(axios.defaults.baseURL + '/updateinsurance',{id: obj.id, option: obj.type, duedate: obj.duedate, notes: obj.notes}).then(result => {
                                     
                           this.refreshData();
            })
        } // end if    
      }, 

         activate:function(el){
                alert("in " + el);
        this.active_el = el;
    },

            gotStriked: function(){
            this.isActive = !this.isActive;
          // some code to filter users
        },  doubleclickedrowmachine(clickedid, status) {

              
            axios.post(axios.defaults.baseURL + '/setmachinestatus',{id: clickedid, active: status}).then(result => {
                            
                            
                           this.refreshData();
            })
           
        },

            doubleclickedrow(clickedid, status) {

              
            axios.post(axios.defaults.baseURL + '/setinsurancestatus',{id: clickedid, active: status}).then(result => {
                            
                            
                           this.refreshData();
            })
           
        },

            select: function(event) {
                var targetId = 0;
            targetId = event.currentTarget;
            alert(targetId);
            console.log(targetId); // returns 'foo'
        },

            filterInsuranceByMachine(id) {                
                // alert(" value " + this.list2[2]['machineid']);
   // this.messarray = JSON.stringify(this.list2, null, 4);   
   
 var result = this.list2.filter(thislist => {
  return thislist['machineid'] === id
})

// alert(JSON.stringify(result, null, 4));


   // alert(" typeof " + typeof(result['active']) + " value " + result['active'] + " id " + result['id']);
  // alert(" typeof " + typeof(result));

  if(this.expiredchecked == true && result.length <= 0 ) {
      // alert("empty id " + id);
      this.brr.push(id);
    
  }

    return result;

  },        expiredClicked() {
              

              this.refreshData();

            },
  
            hiddenClicked() {
            
              this.refreshData();

            },
            showRowInsurance() {
               
               var el = document.getElementById("addinsurancediv");
    el.style.display = (el.style.display != 'none' ? 'none' : '');
            },
            showRowMachine() {
               
               var el = document.getElementById("addmachinediv");
    el.style.display = (el.style.display != 'none' ? 'none' : '');
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
                this.success = '';
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
},          

            refreshData(){
                
                                    axios.get(axios.defaults.baseURL + '/getmachines').then(result => {
                            
                            
                            this.list = result.data[0];
                            
if(this.expiredchecked == true ) {
    
    axios.get(axios.defaults.baseURL + '/getdue').then(gotdue => {   
        
                           this.list2 = gotdue.data[0];
                           // alert(JSON.stringify(this.list2, null, 4));
                           
        }) // end axios
     } // end if true  
     
     if(this.expiredchecked == false) {
                            this.brr = [];
                            this.list2 = result.data[1];
      } // end if false  
                           

//alert(JSON.stringify(this.list2, null, 4));
//alert(typeof(this.list2[1]["active"]));
//alert(this.list2[10]["active"]);


                            // alert(result.data[1][2]["active"]);

                           /*  alert(JSON.stringify(this.list2, null, 4));
                            var r = 0;
                            while(r<this.list2.length) {
                           // this.list2.push({num: r});
                            r++;
                            }
                            alert(JSON.stringify(this.list2, null, 4));
                          */
                /*          
                            alert(JSON.stringify(result.data, null, 4));
                            
                            var k = 0;
                            
                            while(k<this.list.length){
                              alert(result.data[0][k]["id"]);


                               var n = 0;
                               while (n < this.list2.length) {
                               
                              // alert (" result.data[1][n][machineid] " + result.data[1][n]['machineid']);
                              //  alert ( " result.data[0][k][id] " + result.data[0][k]["id"]);
                                if (result.data[1][n]['machineid'] === result.data[0][k]["id"]) {
                               alert(result.data[1][n]["id"]);  
                               } // end if  
                              n++;
                              } // end while n

                              k++;
                            }  // end while k  
                            // alert(result.data[1][0]["type"]);
                    */

            })// end axios

},
            saveMachine(){


                 if (this.machine === '') {
    
    this.errormachine = 'Machine empty !';
                     
                  }

            if (this.machine !== '' ) {

                var el = document.getElementById("addmachinediv");
                el.style.display = "none";
               
                let machineObj = this;
                
                axios.post(axios.defaults.baseURL + '/addmachine',{vin: this.vin, year: this.year, machine: this.machine}).then(response => {
                  // alert(response.data.success);

                  this.vin = this.year = this.machine = "";

                  machineObj.errormachine = response.data.success;

                  this.refreshData();
                  
                   
                  setTimeout(function(){ machineObj.errormachine = ""; }, 3000);
                }) // end axios
           
              } // end if              
               
},                
            saveInsurance(){
                // alert(this.formatDate(this.datesel));


                if (this.notessel === '') {
    console.log("bad");
    this.errormes = 'Notes empty !';
                     
                  }
if (this.datesel === '') {
    console.log("bad date");
    this.errormes = 'Date empty !';                     
                  }
if (this.option === null) {
    console.log("bad option");
    this.errormes = 'Type empty !';                     
                  } 

if (this.optionmachine === null) {
    console.log("bad option machine");
    this.errormes = 'Machine empty !';                     
                  } 


            if (this.notessel !== '' && this.datesel !== '' && this.option !== null && this.optionmachine !== null) {

                var el = document.getElementById("addinsurancediv");
                el.style.display = "none";
                
                this.datesel = this.formatDate(this.datesel);
  //                document.getElementById("notestext").value = "";
                let currentObj = this;
                axios.post(axios.defaults.baseURL + '/addinsurance',{machineid: this.optionmachine, option: this.option, notes: this.notessel, date: this.datesel}).then(response => {
                  // alert(response.data.success);
                  this.notessel = this.datesel = this.option = "";
                  this.option = null;
                  this.optionmachine = null;

                  currentObj.errormes = response.data.success;

                  this.refreshData();
                   
                  setTimeout(function(){ currentObj.errormes = ""; }, 3000);
                })
           
              } // end if
           
           }
        }
    }
</script>

<style>
.yellow {
background-color: yellow;
}
.white {
background-color: white;
}

.striked {
text-decoration: line-through;
}

.hidden {
display:none;
}

.showhidden {
display:'';
}
</style>