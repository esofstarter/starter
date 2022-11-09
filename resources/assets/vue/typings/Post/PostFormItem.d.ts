declare interface PostFormItem {
    id?: number;
    title?: string;
    body?: string;
    categories?: Array<number>;
    uploaded_file: File | null;
    // user_id: number;
    // created_at?: Date;
    // updated_at?: Date;
  }
  