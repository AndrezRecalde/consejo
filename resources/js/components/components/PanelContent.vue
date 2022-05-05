<template>
  <div>
    <v-row>
      <v-col cols="12" sm="12">
        <v-card style="border: 1px solid #e5efff;" :elevation="0">
          <v-card v-if="icono_panel"
            :elevation="8"
            height="100"
            width="100"
            color="system"
            style="border-radius:10px;position: absolute;margin-left: 20px;margin-top:-25px;z-index: 1;"
          >
            <span
              class="material-icons white--text"
              style="font-size: 45px;  margin: auto; padding: 28px;"
            >{{icono_panel}}</span>
          </v-card>
          <v-card-title v-if="title"
            :style="{'color':$vuetify.theme.currentTheme.title,
            'border-bottom':(borderBotom==null?'1px solid #4242422e':borderBotom),
            'padding-top': '10px', 'padding-bottom': '10px'}"
          >
            <strong :style="{'margin-left':icono_panel ? '130px' : ''}">
              {{title}}
              <v-chip
                v-if="subtitle!=undefined && subtitle!='' && subtitle!=null && subtitle!='null'"
                class="font-italic font-weight-medium"
              >{{subtitle}}</v-chip>
            </strong>
              <v-spacer></v-spacer>
           
<div class="panel-optionsbuttonstop-responsive">
            <template>
              <slot name="optionsbuttonstop"></slot>
            </template>
            </div>
          </v-card-title>
          <v-card-text class="mb-5">
            <template>
              <slot name="header"></slot>
            </template>
            <template>
              <slot name="content"></slot>
            </template>
          </v-card-text>
          <v-card-actions>
            <template>
              <slot name="footer"></slot>
            </template>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script>
export default {
  name: "PanelContent",
  props: ["title", "options", "subtitle","icono_panel","borderBotom"] //subtitle optional
};
</script>



