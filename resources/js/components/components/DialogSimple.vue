<template>
    <div>
        <v-dialog
            persistent
            :fullscreen="!$store.state.dialogSimple.maxwidth"
            v-model="$store.state.dialogSimple.dialog"
            :max-width="$store.state.dialogSimple.maxwidth"
            scrollable
            :hide-overlay="!$store.state.dialogSimple.maxwidth"
            :transition="
                !$store.state.dialogSimple.maxwidth
                    ? 'dialog-bottom-transition'
                    : 'scale-transition'
            "
        >
            <v-card>
                <v-card-title
                    class="  black--text" 
                >
                    {{ $store.state.dialogSimple.titulo }}
                    <v-spacer></v-spacer>
                    <template>
                        <slot
                            :name="$store.state.dialogSimple.optionsbuttonstop"
                        ></slot>
                    </template>
                </v-card-title>
                <v-divider class="mx-2 my-1 "></v-divider>
                <v-card-text>
                    <template>
                        <slot :name="$store.state.dialogSimple.bodycard"></slot>
                    </template>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <slot :name="$store.state.dialogSimple.buttons"> </slot>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
            persistent
            :fullscreen="!$store.state.dialogSimple2.maxwidth"
            v-model="$store.state.dialogSimple2.dialog"
            :max-width="$store.state.dialogSimple2.maxwidth"
            scrollable
            :hide-overlay="!$store.state.dialogSimple2.maxwidth"
            :transition="
                !$store.state.dialogSimple2.maxwidth
                    ? 'dialog-bottom-transition'
                    : 'scale-transition'
            "
        >
            <v-card>
                <v-card-title
                    class=" black--text"
                >
                    {{ $store.state.dialogSimple2.titulo }}
                    <v-spacer></v-spacer>
                    <template>
                        <slot
                            :name="$store.state.dialogSimple2.optionsbuttonstop"
                        ></slot>
                    </template>
                </v-card-title>
                <v-divider class="mx-2"></v-divider>
                <v-card-text>
                    <template>
                        <slot :name="$store.state.dialogSimple2.bodycard">
                        </slot>
                    </template>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <slot :name="$store.state.dialogSimple2.buttons"></slot>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
            persistent
            v-model="$store.state.dialogSimple3.dialog"
            :max-width="$store.state.dialogSimple3.maxwidth"
            scrollable
        >
            <v-card>
                <v-card-title
                    class=" blue darken-4 white--text"
                >
                    {{ $store.state.dialogSimple3.titulo }}
                    <v-spacer></v-spacer>
                    <template>
                        <slot
                            :name="$store.state.dialogSimple3.optionsbuttonstop"
                        ></slot>
                    </template>
                </v-card-title>
                <v-card-text>
                    <template>
                        <slot :name="$store.state.dialogSimple3.bodycard">
                        </slot>
                    </template>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <slot :name="$store.state.dialogSimple3.buttons"></slot>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
            persistent
            v-model="$store.state.dialogSimple4.dialog"
            :max-width="$store.state.dialogSimple4.maxwidth"
            scrollable
        >
            <v-card>
                <v-card-title
                    class=" blue darken-4 white--text"
                >
                    {{ $store.state.dialogSimple4.titulo }}
                    <v-spacer></v-spacer>
                    <template>
                        <slot
                            :name="$store.state.dialogSimple4.optionsbuttonstop"
                        ></slot>
                    </template>
                </v-card-title>
                <v-card-text>
                    <template>
                        <slot :name="$store.state.dialogSimple4.bodycard">
                        </slot>
                    </template>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <slot :name="$store.state.dialogSimple4.buttons"></slot>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default {
    props: ["dialog", "dialog2", "dialog3", "dialog4"],
    name: "DialogSimple",
    data() {
        return {
            notifications: false,
            sound: true,
            widgets: false,
            titulo: "",
            maxwidth: "500px"
        };
    },
    mounted() {}
};
</script>
