import Swal from "sweetalert2";
import { round } from "lodash";
import Cookie from "js-cookie";

export const setToken = (state, payload) => {
	try {
		Cookie.set("authToken", payload,{expires:365});
		state.token = payload;
	} catch (error) {
		return false;
	}
};

export const setUser = (state, payload) =>{
	try {
		Cookie.set("authUser", JSON.stringify(payload), {expires:365});
		state.user = payload;
	} catch (error) {
		return false;
	}
};
export const setConfig = (state, payload) => {
	state.config = payload
};
export const setHeaders = (state, payload) => {
	state.headers = {
		headers: {
			Authorization: payload,
		},
	};
};
export const logout = (state) => {
	Cookie.remove("authUser");
	Cookie.remove("authToken");
};
export const openSweetAlertBlocked = (state, data) => {
	let timerInterval;
	Swal.fire({
		title: data.mensajeLoading,
		html: data.mensaje,
		timer: data.time,
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		didOpen: () => {
			Swal.showLoading();
			timerInterval = setInterval(() => {
				try {
					const content = Swal.getContent();
					if (content) {
						const b = content.querySelector("b");
						if (b) {
							b.textContent = round(
								Swal.getTimerLeft() / 1000
							);
						}
					}
				} catch (error) {
					clearInterval(timerInterval);
				}
			}, 100);
		},
		willClose: () => {
			clearInterval(timerInterval);
		},
	}).then((result) => {});
};
export const openDialogSimple = (state, data) => {
	state.dialogSimple.bodycard = data.bodycard;
	state.dialogSimple.buttons = data.buttons;
	state.dialogSimple.optionsbuttonstop = data.optionsbuttonstop;
	state.dialogSimple.dialog = data.openDialog;
	state.dialogSimple.titulo = data.titulo;
	state.dialogSimple.maxwidth = data.maxwidth;
	state.dialogSimple.transition = data.transition;
	state.dialogSimple.data = data.data;
};
export const openDialogSimple2 = (state, data) => {
	state.dialogSimple2.bodycard = data.bodycard;
	state.dialogSimple2.buttons = data.buttons;
	state.dialogSimple2.optionsbuttonstop = data.optionsbuttonstop;
	state.dialogSimple2.dialog = data.openDialog;
	state.dialogSimple2.titulo = data.titulo;
	state.dialogSimple2.maxwidth = data.maxwidth;
	state.dialogSimple2.data = data.data;
};
export const openDialogSimple3 = (state, data) => {
	state.dialogSimple3.bodycard = data.bodycard;
	state.dialogSimple3.buttons = data.buttons;
	state.dialogSimple3.optionsbuttonstop = data.optionsbuttonstop;
	state.dialogSimple3.dialog = data.openDialog;
	state.dialogSimple3.titulo = data.titulo;
	state.dialogSimple3.maxwidth = data.maxwidth;
	state.dialogSimple3.data = data.data;
};
export const openDialogSimple4 = (state, data) => {
	state.dialogSimple4.bodycard = data.bodycard;
	state.dialogSimple4.buttons = data.buttons;
	state.dialogSimple4.optionsbuttonstop = data.optionsbuttonstop;
	state.dialogSimple4.dialog = data.openDialog;
	state.dialogSimple4.titulo = data.titulo;
	state.dialogSimple4.maxwidth = data.maxwidth;
	state.dialogSimple4.data = data.data;
};
export const closeDialog = (state, data) => {
	state[data.tipo].dialog = data.value 
};
export const onResize = (state) => {
	state.windowSize = { x: window.innerWidth, y: window.innerHeight };
};