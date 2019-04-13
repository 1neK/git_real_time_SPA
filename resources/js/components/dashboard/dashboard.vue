<template>
    <div>
        <v-container fluid grid-list-md >
        <v-layout row wrap>
                <v-flex xs3 md2>
                    <h2>Dashboard</h2>
                </v-flex>

            <v-flex xs3 md10>
                    <v-card-text class="px-0"> <h4> Filter </h4> </v-card-text>
            </v-flex>

            <v-flex xs2></v-flex>

            <v-flex xs2>
                    <v-card-text class="px-0">Project</v-card-text>
                    <v-combobox
                    v-model="select1"
                    :items="items1"
                    label="Project"
                ></v-combobox>
            </v-flex>
            <v-flex xs2>
                    <v-card-text class="px-0">Affected To</v-card-text>
                    <v-combobox
                    v-model="select2"
                    :items="items2"
                    label="Affected To"
                ></v-combobox>
            </v-flex>
            <v-flex xs2>
                <v-card-text class="px-0">Month</v-card-text>
                    <v-combobox
                    v-model="select3"
                    :items="items3"
                    label="Month"
                    ></v-combobox>
            </v-flex>
            <v-flex xs2>
                    <v-card-text class="px-0">Year</v-card-text>
                    <v-combobox
                    v-model="select4"
                    :items="items4"
                    label="Year"
                ></v-combobox>
            </v-flex>

            <v-flex xs3>
                <v-hover>
                    <v-card
                    slot-scope="{ hover }"
                    :class="`elevation-${hover ? 12 : 2}`"
                    class="mx-auto"
                    width="344"
                    >
                    <v-card-title >
                        <div xs6>
                            <v-flex>
                                <v-flex>
                                    <v-icon>check_circle</v-icon>
                                </v-flex>
                                <v-flex>
                                    Total Validated
                                </v-flex>
                            </v-flex>
                            <v-flex>
                                <v-flex>
                                    <v-icon>check_circle</v-icon>
                                </v-flex>
                                <v-flex>
                                    Total Completed
                                </v-flex>
                            </v-flex>
                        </div>
                        <v-flex xs6>
                            <v-flex>
                                    <v-icon>check_circle</v-icon>
                            </v-flex>
                            <v-flex>
                                Productivity
                            </v-flex>
                        </v-flex>
                        <v-spacer></v-spacer>
                    </v-card-title>
                    </v-card>
                </v-hover>
            </v-flex>
            <!--<v-spacer></v-spacer>-->
            <v-flex xs6></v-flex>
            <v-flex xs10></v-flex>
            <v-flex xs2>
                <v-btn color="grey"> Download Excell </v-btn>
            </v-flex>

            <v-container>
                        <v-data-table colmd12  :headers="headers" :items="tasks" class="elevation-1">
                            <template v-slot:items="props">
                                <td>{{ props.item.project }}</td>
                                <td class="text-center">{{ props.item.type }}</td>
                                <td class="text-center">{{ props.item.user }}</td>
                                <td class="text-center">{{ props.item.start_date }}</td>
                                <td class="text-center">{{ props.item.due_date }}</td>
                                <td class="text-center">{{ props.item.status }}</td>
                                    <td class="text-center">
                                        <v-btn icon @click="edit(props.item)">
                                            <v-icon medium color="green">edit</v-icon>
                                        </v-btn>
                                        <v-btn icon @click="destroy( props.item.id )">
                                            <v-icon medium color="red"> delete</v-icon>
                                        </v-btn>
                                    </td>
                            </template>
                        </v-data-table>
                        </v-container>


        </v-layout>
    </v-container>
    </div>
</template>

<script>
export default {
    data(){
        return{
            /*select1: 'Ins'
            items1: [

            ],*/
        }
    }

}
</script>

<style>

</style>
