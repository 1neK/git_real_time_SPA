import Token from "./Token";
import AppStorage from './AppStorage'
class User{
    login(data,router){ /* router :this.$router */

        axios.post('/api/auth/login',data)
        .then(res =>this.responseAfterLogin(res,router))
        .catch(error => console.log(error.response))
    }
responseAfterLogin(res,router){
const access_token = res.data.access_token
const user = res.data.user
//console.log(access_token);
if(access_token != ''){

    AppStorage.storeToken(access_token);
    AppStorage.storeUser(user.name);



   if(user.role_id ==1 ){
    AppStorage.storeRole('admin');
    window.location='/admin'

    }
    if(user.role_id ==2 ){
        AppStorage.storeRole('designer');

        window.location='/designer'

    }
    if(user.role_id ==3 ){
        console.log('coordinator')

        AppStorage.storeRole('coordinator');

        window.location='/coordinator'

    }



}

}

hasToken(){

    const storedToken = AppStorage.getToken();

    if (storedToken){

            return  true ;
        }


        return false;

}

loggedIn(){

    return this.hasToken()


}

logout()
{
    AppStorage.clear()
    window.location='/forum'
}

name()
{
    if(this.loggedIn()){
        return AppStorage.getUser()
    }
}
id()
{
    if(this.loggedIn()){
        const payload = Token.payload(AppStorage.getToken())
        return payload.sub
    }
}

own(id){
    return this.id() == id

}

admin(){
   return AppStorage.getRole()=='admin';
}


}


export default User = new User()
