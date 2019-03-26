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
console.log(access_token);
if(access_token != ''){

    AppStorage.store(user.name,access_token);
    console.log(AppStorage.getToken());



    if(user.role_id =='1' ){
        console.log('admin')
         router.push({name:'admin'})

    }
    if(user.role_id ==2 ){
        console.log('designer')

        router.push({name:'admin'})

    }
    if(user.role_id ==3 ){
        console.log('coordinator')
        router.push({name:'coordinator'})

    }
   // window.location='/forum'

}

}

hasToken(){

    const storedToken = AppStorage.getToken();
    console.log(storedToken);
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
    return this.id() ==id

}

admin(){
    return this.id() == 1
}


}


export default User = new User()
