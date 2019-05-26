import Token from "./Token";
import AppStorage from './AppStorage'


class User {
    login(data) {


        axios.post('/api/auth/login', data)
            .then(res => this.responseAfterLogin(res))
            .catch(error => this.$swal(error.response.data.error))
    }

    responseAfterLogin(res) {
        const access_token = res.data.access_token
        const user = res.data.user

        if (access_token != '') {

            AppStorage.storeToken(access_token);
            AppStorage.storeUser(user.name);

            AppStorage.storeRole(user.role);


            window.location = '/';


        }

    }

    hasToken() {

        const storedToken = AppStorage.getToken();

        if (storedToken) {

            return true;
        }


        return false;

    }

    loggedIn() {

        return this.hasToken()


    }

    logout() {
        AppStorage.clear();
        // window.location = '/login'
    }

    name() {
        if (this.loggedIn()) {
            return AppStorage.getUser()
        }
    }

    id() {
        if (this.loggedIn()) {
            const payload = Token.payload(AppStorage.getToken())
            return payload.sub
        }
    }

    own(id) {
        return this.id() == id

    }

    admin() {

        return AppStorage.getRole() == 'Admin';

    }

    coordinator() {
        return AppStorage.getRole() == 'Coordinator';
    }


}


export default User = new User()
