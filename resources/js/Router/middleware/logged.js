import AppStorage from '../../Helpers/AppStorage'


export default function log({next, router}) {

    if (AppStorage.getToken()) {

    } else {


        return router.push({name: 'login'});
    }

    return next();
}
