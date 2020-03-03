<template>
<div class="row">
    <div class="col-12">

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Kliendikood</th>
                    <th scope="col">Eesnimi</th>
                    <th scope="col">Perekonnanimi</th>
                    <th scope="col">Telefon</th>
                    <th scope="col">E-post</th>
                    <th scope="col" v-if="editmode" id="hide">Kustuta</th>
                </tr>
            </thead>

                <!--Add New Client-->
                
                <tr v-for="entry in newEntry" :key="entry.name" id="entries" v-if="editmode">                    
                    <td>id</td>
                    <td><span v-if="entry.editmode"><input v-on:blur="addContact(entry)" v-model="entry.eesnimi" /></span>
                        <span @click="addContact(entry)" v-else>{{ entry.eesnimi }}</span></td>
                    <td><span v-if="entry.editmode"><input v-on:blur="addContact(entry)" v-model="entry.perekonnanimi" /></span>
                        <span @click="addContact(entry)" v-else>{{ entry.perekonnanimi }}</span></td>
                    <td><span v-if="entry.editmode"><input v-on:blur="addContact(entry)" v-model="entry.telefon" /></span>
                        <span @click="addContact(entry)" v-else>{{ entry.telefon }}</span></td>
                    <td><span v-if="entry.editmode"><input v-on:blur="addContact(entry)" v-model="entry.email" /></span>
                        <span @click="addContact(entry)" v-else>{{ entry.email }}</span></td>
                    <td v-on:click="editmode = false;">X</td>
                </tr>                

                <!--Contacts table-->
            <draggable v-model="list" tag="tbody" @update="onUpdate" :list="list">
                <tr v-for="item in list" :key="item.name" id="items">
                    <td scope="row">{{ item.id }}</td>
                    <td><span v-if="item.editmode"><input v-on:blur="editContact(item)" v-model="item.firstName" /></span>
                        <span @click="editContact(item)" v-else>{{ item.firstName }}</span></td>
                    <td><span v-if="item.editmode"><input v-on:blur="editContact(item)" v-model="item.lastName" /></span>
                        <span @click="editContact(item)" v-else>{{ item.lastName }}</span></td>
                    <td><span v-if="item.editmode"><input v-on:blur="editContact(item)" v-model="item.phone" /></span>
                        <span @click="editContact(item)" v-else>{{ item.phone }}</span></td>
                    <td><span v-if="item.editmode"><input v-on:blur="editContact(item)" v-model="item.email" /></span>
                        <span @click="editContact(item)" v-else>{{ item.email }}</span></td>
                    <td v-if="editmode" v-on:click="deleteContact(item.id)" id="hiden">X</td>
                </tr>
            </draggable>
        </table>

        <div v-if="editmode" class="row">
            <div class="col-12">
                <div v-if="errormessage != ''" class="alert alert-success" role="alert">{{errormessage}}</div>
            </div>
        </div>

    </div>
</div>
</template>

<script>
import draggable from 'vuedraggable';
import _ from 'lodash';

export default {
    
    components: {
        draggable
    },
    mounted() {
        var refcomp = this;
        refcomp.refreshData();

    },
    data() {
        return {
            list: [{
                id: 1,
                firstName: "",
                lastName: "",
                phone: "",
                email: "",
                sortid: 1
            }],
            newEntry: [{
                id: 1,
                eesnimi: "...",
                perekonnanimi: "...",
                telefon: "...",
                email: "...@...",
                sortid: 1
            }],
            selected: null,
            errormessage: '',
            email: null,
            // Validate email entry
            reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            dragging: false,
            editingstatus: false,
            editmode: false
        };
    },
    computed: {
        maxSequence: function () {
            var maximumSequence = 0;
            this.list.map(function (obj) {
                if (obj.sequence > maximumSequence) maximumSequence = obj.sequence;
            });
            return maximumSequence + 1;
        }
    },
    methods: {

        refreshData() {
            axios.get(axios.defaults.baseURL + '/contacts').then(result => {

                // alert("data " + result.data[0]["data"][0]["lastName"]);
                this.list = result.data[0]["data"];
                this.list = _.orderBy(this.list, 'sequence', 'asc');

            }) // end axios

        },
        changeEditMode() {
            this.editmode = !this.editmode;
        },

        // Vue Draggable table updated or rows dragged
        onUpdate() {
            
            this.$emit('updated', this.list);
            this.updateSequence();

        },

        // Sorting selected
        handleChange(e) {
            var id = e.target.value; {

                switch (id) {
                    case '2':
                        this.list = _.orderBy(this.list, 'id', 'asc');
                        this.updateSequence();
                        break;
                    case '3':
                        this.list = _.orderBy(this.list, 'id', 'desc');
                        this.updateSequence();
                        break;
                    case '4':
                        this.list = _.orderBy(this.list, 'lastName', 'asc');
                        this.updateSequence();
                        break;
                    case '5':
                        this.list = _.orderBy(this.list, 'lastName', 'desc');
                        this.updateSequence();
                        break;
                }

            }
        },

        addContact: function (obj) {
            // this.$set(obj, 'editmode', true);
            this.editingstatus = !this.editingstatus;
            this.$set(obj, 'editmode', this.editingstatus);
                    

            // alert(JSON.stringify(obj));

            if (obj.eesnimi == null || obj.eesnimi == '' || obj.eesnimi == '...') {
                this.errormessage = "Palun sisesta eesnimi";
                obj.eesnimi = '...';
                return;
            } else {
                this.errormessage = "";
            }
            if (obj.perekonnanimi == null || obj.perekonnanimi == '' || obj.perekonnanimi == '...') {
                this.errormessage = "Palun sisesta perekonnanimi";
                obj.perekonnanimi = '...';
                return;
            } else {
                this.errormessage = "";
            }
            if (obj.telefon == null || obj.telefon == '' || obj.telefon == '...') {
                this.errormessage = "Palun sisesta telefon";
                obj.telefon = '...';
                return;
            } else {
                this.errormessage = "";
            }
            if (obj.email == null || obj.email == '') {
                this.errormessage = "Palun sisesta e-post";
                obj.email = '...@...';
                return;
            } else if (!this.reg.test(obj.email)) {
                this.errormessage = "E-posti aadress on vale";
                return;
            } else {
                this.errormessage = "";
            }

            if (this.editingstatus == false) {

                var request = require('request');

                var headers = {
                    'accept': 'application/json',
                    'Content-Type': 'application/json'
                };

                var newSequence = this.maxSequence;
                var dataString = '{"firstName":"' + obj.eesnimi + '","lastName":"' + obj.perekonnanimi + '","email":"' + obj.email + '","phone":"' + obj.telefon + '","sequence":' + newSequence + '}';

                var options = {
                    url: window.axios.defaults.apiURL + '/Contacts',
                    method: 'POST',
                    headers: headers,
                    body: dataString
                };

                function callback(error, response, body) {
                    if (!error && response.statusCode == 200) {
                        console.log(body);
                    }
                }

                request(options, callback);
                this.editmode = false;
                window.location.reload();
                this.refreshData();

            } // end if    

        },

        editContact: function (obj) {
            // this.$set(obj, 'editmode', true);

            
            this.editingstatus = !this.editingstatus;

            this.$set(obj, 'editmode', this.editingstatus);


            if (this.editingstatus == false) {

            
                this.updateSequence();
                this.refreshData();

            } // end if    

        },

        deleteContact(id) {

            this.editingstatus = !this.editingstatus;

            var request = require('request');

            var headers = {
                'accept': '*/*'
            };

            var deleteurl = window.axios.defaults.apiURL + '/Contacts/' + id;

            var options = {
                url: deleteurl,
                method: 'DELETE',
                headers: headers
            };

            function callback(error, response, body) {
                if (!error && response.statusCode == 200) {
                    console.log(body);
                }
            }

            request(options, callback);

            this.refreshData();

        },

        // Clean Table Cell value
        cleanCellValue: function (event) {

            event.currentTarget.innerHTML = '';

        },

        //  Save Table data sequence selected by User
        updateSequence() {

            this.list.forEach(function (entry, index) {

                var request = require('request');

                var headers = {
                    'accept': 'application/json',
                    'Content-Type': 'application/json'
                };

                var dataString = '{"id":' + entry.id + ',"firstName":"' + entry.firstName + '","lastName":"' + entry.lastName + '","fullName":"' + entry.fullName + '","email":"' + entry.email + '","phone":"' + entry.phone + '","sequence":' + index + '}';

                var requesturl = window.axios.defaults.apiURL + '/Contacts/' + entry.id;

                var options = {
                    url: requesturl,
                    method: 'PATCH',
                    headers: headers,
                    body: dataString
                };

                function callback(error, response, body) {
                    if (!error && response.statusCode == 200) {
                        console.log(body);
                    }
                }

                process.env["NODE_TLS_REJECT_UNAUTHORIZED"] = 0;
                request(options, callback);

            });

        } // end updateSequence

    } // end Methods
}; // end Export defaults
</script>

<style scoped>
.buttons {
    margin-top: 35px;
}

.alert-success {
    background-color: white !important;
    border-color: white !important;    
}
</style>
