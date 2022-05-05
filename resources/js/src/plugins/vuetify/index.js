import Vuetify from "vuetify";

import es from "vuetify/es5/locale/es";
var light = {
	primary: "#0088ff",
	secondary: "#0a1f8f",
	third: "#0f206c",
	fourth: "#0097ce",
	fifth: "#eb0045",
	sixth: "#592c82",

	white: "#fff",
	accent: "#82B1FF",
	error: "#FF5252",
	success: "#46be8a",
	warning: "#FFC107",
	new: "#bf0909",
	edit: "#fab414",
	delete: "#ED303C",
	undelete: "#18abb8",
	restart: "#7B3095",
	play: "#F07818",
	complete: "#30963D",
	load: "#28De7e",
	system: "#ffde59",
	grey: "#999999"
};

light.search = '#0088ff';
light.download = '#0088ff';
light.modalbackgroundtitle = '#328ee4';
light.send = '#0088ff';
light.title = '#24374e';
light.info = light.primary;
light.view = '#62a8ea';
light.back = '#526069';
light.headerbuttons = '#0088ff';

var vuetify = new Vuetify({
	icons: {
		iconfont: "md"
	},
	lang: {
		locales: { es },
		current: "es"
	},
	theme: {
		themes: {
			light: light
		}
	}
});

export default vuetify;
