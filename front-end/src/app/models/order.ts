import { OrderDetails } from './orderDetails';

export interface Order {
  id: number;
  user_id: number;
  total_price: number;
  created_at: Date;
  updated_at: Date;
  status: string;
  products: OrderDetails[];
}
