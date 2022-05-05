import Swal from "sweetalert2";
import moment from "moment";
import 'moment/locale/es'
import Cookie from "js-cookie";

export const getUser = (state) => {
	try {
		let user = Cookie.get("authUser")
			? JSON.parse(Cookie.get("authUser") || "{}")
			: false;
		return user;
		//return state.user
	} catch (error) {
		return false;
	}
};
export const getToken = (state) => {
	try {
		return Cookie.get("authToken") || state.token;
	} catch (error) {
		return false;
	}
};
export const getHeaders = (state) => state.headers;
export const getSwal = (state) => Swal;
export const getToastDefault = (state) => {
	return Swal.mixin({
		toast: true,
		position: "bottom-end",
		showConfirmButton: false,
		timer: 5000,
		timerProgressBar: true,
		onOpen: (toast) => {
			toast.addEventListener("mouseenter", state.swal.stopTimer);
			toast.addEventListener("mouseleave", state.swal.resumeTimer);
		},
	});
};
export const isAuthenticated = (state) => {
	return state.auth.loggedIn;
};
export const loggedInUser = (state) => {
	return state.auth.user;
};
export const getMoment = (state) => moment;
export const isExtraSmall = (state) => {
	return state.windowSize.x <= 600;
};
export const isSmall = (state) => {
	return state.windowSize.x > 600 && state.windowSize.x <= 960;
};
export const isMedium = (state) => {
	return state.windowSize.x > 960 && state.windowSize.x <= 1250;
};
export const isMediumMayor = (state) => {
	return state.windowSize.x > 1250 && state.windowSize.x <= 1900;
};
export const isLarge = (state) => {
	return state.windowSize.x > 1900;
};
