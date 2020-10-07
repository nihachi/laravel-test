import { getLocalUser } from '../services/auth';
import axios from 'axios';

import auth from './modules/auth';

const currentUser = getLocalUser();

if (!currentUser) {
  axios.defaults.headers.common['Authorization'] = null;
} else {
  axios.defaults.headers.common[
    'Authorization'
  ] = `Bearer ${currentUser.token}`;
}

export default {
  modules: {
    auth
  },
};
