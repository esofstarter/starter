import { createFile } from '@/utils/edgeFileUpload';

const user: UserFormItem = {
  id: 0,
  username: '',
  email: '',
  first_name: '',
  last_name: '',
  password: '',
  password_confirmation: '',
  roles: [],
  roles_array: [],
  is_disabled: 0,
  country_id: 0,
  uploaded_file: createFile('image/jpg'),
  json_data: '',
  company: '',
  phone: '',
  source: 'backend',
  contact_email: ''
};

export {
  user
};
