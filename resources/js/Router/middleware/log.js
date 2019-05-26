import AppStorage from '../../Helpers/AppStorage'


export default function log({ next, router }) {
    // eslint-disable-next-line no-console


  if(!AppStorage.getToken())
  {


  }else {


    return router.push({ name: 'home' });
  }

    return next();
  }
