class AppStorage {

    storeToken(token){
         localStorage.setItem('token',token)
    }
    storeUser(user){
        localStorage.setItem('user',user);
    }
    storeRole(role){
        localStorage.setItem('role',role);
    }

    store(user,token,role){
        this.storeToken(token)
        this.storeUser(user)
        this.storeUser(role)
    }

clear(){

    localStorage.removeItem('token')
    localStorage.removeItem('user')
    localStorage.removeItem('role')
}

getToken(){
    return localStorage.getItem('token')
}

getUser(){
    return localStorage.getItem('user')
}

getRole(){
    return localStorage.getItem('role')
}


}

export default AppStorage = new AppStorage()
