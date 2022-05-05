const cookieparser = process.server ? require("cookieparser") : undefined;
// importing server based cookie library

export async function nuxtServerInit(
	{ commit, getters, state },
	{ app, req, res }
) {
	// If we have any axios requests we need to add async/await
	// And since this works on server mode, we don't need to check is it server

	let token = null,
		user;
	let parsed;
	if (req.headers.cookie) {
		parsed = cookieparser.parse(req.headers.cookie);
		try {
			token = parsed.authToken;
		} catch (e) {
			console.log(e);
		}
	}
	if (token) {
		this.$axios.defaults.headers.common['Authorization'] = token;
		await this.$axios
			.get(state.routes.http.getauthuser)
			.then((response) => {
				let data = response.data;
				if (typeof data.error != "undefined") {
					res.setHeader("Set-Cookie", [
						`authToken=false; expires=Thu, 01 Jan 1970 00:00:00 GMT`,
					]);
					commit("logout");
					setTimeout(() => {
						window.location.reload();
					}, 500);
					app.$cookies.set("authUser", "");
					app.$cookies.set("authToken", "");
				} else {
					commit("setUser", data);
					commit("setConfig", data.config);
					//commit("setToken", data.token);
					//commit("setHeaders", data.token);
				}
			})
			.catch((error) => {
				this.$axios
					.get(state.routes.http.logout)
					.then(() => {
						app.$cookies.set("authUser", "");
						app.$cookies.set("authToken", "");
						res.setHeader("Set-Cookie", [
							`authToken=false; expires=Thu, 01 Jan 1970 00:00:00 GMT`,
						]);
						commit("logout");
						setTimeout(() => {
							window.location.reload();
						}, 500);
					});
			});
	}
}
