import AppStorage from '../../Helpers/AppStorage'


export default function log({next, router}) {

    if (!AppStorage.getToken())   return router.push({name: 'login'});

    return next();
}
