import AppStorage from '../../Helpers/AppStorage'


export default function log({ next, router }) {
    // eslint-disable-next-line no-console



  if(AppStorage.getToken() && AppStorage.getRole=="coordinator")
  {

  }else {


    return router.push({ name: 'login' });
  }

    return next();
  }
