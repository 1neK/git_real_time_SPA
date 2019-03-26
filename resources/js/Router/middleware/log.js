import AppStorage from '../../Helpers/AppStorage'


export default function log({ next, router }) {
    // eslint-disable-next-line no-console


    console.log('token :'+AppStorage.getToken());
  if(!AppStorage.getToken())
  {
      console.log('not logged');
  }else {


    return router.push({ name: 'forum' });
  }

    return next();
  }
