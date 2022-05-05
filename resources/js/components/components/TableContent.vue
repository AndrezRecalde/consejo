<template>
	<div>
		<v-data-table
			:headers="computedHeaders"
			:items="items"
			:search="search"
			:items-per-page="itemsPerPage ? itemsPerPage : 10"
			sort-by="calories"
			:sort-field="sortfield"
			:sort-desc="sortdesc"
			:class="'TableContent elevation-0 ' + classTable"
			:loading="loading"
			loading-text="Cargando... Por favor espere"
			style="border-radius:10px;"
		>
			<template v-slot:top v-if="!hidetop">
				<v-toolbar style="border-radius:10px;" flat color="white">
					<template v-if="title != null">
						<v-toolbar-title class="black--text">{{ title }}</v-toolbar-title>
						<v-divider class="mx-4" inset vertical></v-divider>
					</template>
					<template>
						<slot name="inputsAsideSearch"></slot>
					</template>
					<v-spacer></v-spacer>

					<v-text-field
						v-model="search"
						append-icon="search"
						label="Buscar"
						single-line
						hide-details
					></v-text-field>
				</v-toolbar>
			</template>

			<template v-slot:[`item.action`]="{ item }">
				<slot name="btnAcciones" :item="item"></slot>
			</template>

			<template v-slot:[`item.estado`]="{ item }">
				<slot name="Estados" :item="item"></slot>
			</template>
            <template v-slot:[`item.predeterminada_pagina_pago`]="{ item }">
				<slot name="predeterminada_pagina_pago" :item="item"></slot>
			</template>
            <template v-slot:[`item.finger_lista`]="{ item }">
				<slot name="finger_lista" :item="item"></slot>
			</template>
			 <template v-slot:[`item.finger_nivel_riesgo`]="{ item }">
				<slot name="finger_nivel_riesgo" :item="item"></slot>
			</template>
			<!--/template-->
			<template v-slot:[`item.id`]="{ item }">
				<!--para todas los registros que tengan la cabecera-->
				{{
					items
						.map(function(x) {
							return x.id;
						})
						.indexOf(item.id) + 1
				}}
			</template>
			<template v-slot:[`item.fecha_creacion`]="{ item }">
				<!--para todas los registros que tengan la cabecera-->
				{{ moment(item.fecha_creacion).format("DD-MM-YYYY") }}
			</template>
            <template v-slot:[`item.fecha_modificacion`]="{ item }">
				<!--para todas los registros que tengan la cabecera-->
				{{ moment(item.fecha_modificacion).format("DD-MM-YYYY") }}
			</template>
			<template v-slot:no-data>
				<v-alert
					:value="true"
					color="grey"
					style="color:white; margin-top: 13px;"
					icon="warning"
					>Lo sentimos, no existen registros.</v-alert
				>
			</template>
		</v-data-table>
		<template>
			<div class="pt-2">
				<slot name="footerDataTable"></slot>
			</div>
		</template>
	</div>
</template>
<script>
export default {
	props: [
		"title",
		"headers",
		"items",
		"loading",
		"name",
		"sortfield",
		"sortdesc",
		"hidetop",
		"itemsPerPage",
		"classTable"
	], //name,sortfield,sortdesc es opcional
	data: () => ({
		dialog: false,
		search: ""
	}),

	created() {},
	computed: {
		//$slots.precioUnitarioFacturacion

		computedHeaders() {
			return this.headers.filter(x => {
				return x.hidden == null || x.hidden == false;
			});
		}
	},
	methods: {
		hasSlot(...args) {
			var self = this;
			return args.some(nameSlot => {
				return self.$scopedSlots[nameSlot];
			});
		}
	}
};
</script>
