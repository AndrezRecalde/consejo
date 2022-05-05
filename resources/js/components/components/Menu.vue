<template>
	<div>
		<template v-if="list_menu.length == 1">
			<template v-for="(item, i) in list_menu">
				<v-btn
					icon
					:class="item.class"
					:key="i"
					v-if="typeof item._if != 'undefined' ? item._if : true"
					@click="item.click(_item, item.params)"
				>
					<v-icon class="white--text" small>{{ item.icono }}</v-icon>
				</v-btn>
			</template>
		</template>
		<v-menu
			v-else
			transition="slide-x-transition"
			bottom
			:right="getoptions.right || true"
			:left="getoptions.left"
		>
			<template v-slot:activator="{ on }">
				<v-btn
					:elevation="getoptions.elevation"
					:small="small"
					:icon="icon"
					:fab="!icon"
					:class="clase"
					:color="color"
					dark
					v-on="on"
				>
					<v-icon dark>{{ icon_name }}</v-icon
					>{{ btn_name }}
				</v-btn>
			</template>
			<v-list>
				<template v-for="(item, i) in list_menu">
					<v-list-item
						small
						:key="i"
						v-if="typeof item._if != 'undefined' ? item._if : true"
						@click="item.click(_item, item.params)"
					>
						<v-list-item-title>
							<v-btn small icon :class="item.class">
								<v-icon class="white--text" small>{{ item.icono }}</v-icon> </v-btn
							>&nbsp;&nbsp;{{ item.nombre }}
						</v-list-item-title>
					</v-list-item>
				</template>
			</v-list>
		</v-menu>
	</div>
</template>
<script>
export default {
	name: "DialogSimple",
	props: [
		"list_menu",
		"_item",
		"small",
		"clase",
		"icon",
		"icon_name",
		"btn_name",
		"color",
		"options",
	],
	data() {
		return {};
	},
	mounted() {},
	computed: {
		getoptions() {
			return typeof this.options != "undefined"
				? {
						right: typeof this.options.right != "undefined",
						left: typeof this.options.left != "undefined",
						elevation:
							typeof this.options.elevation != "undefined"
								? this.options.elevation
								: 5,
				  }
				: { right: false, left: false, elevation: 5 };
		},
	},
};
</script>
