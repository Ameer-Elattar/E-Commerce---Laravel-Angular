import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import {OrderService} from '../services/order.service';
import { Order } from '../models/order';

import { CommonModule } from '@angular/common';



@Component({
  selector: 'app-orders',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './orders.component.html',
  styleUrl: './orders.component.css'
})
export class OrdersComponent implements OnInit{

  constructor(public OrderService: OrderService ,public router:Router) { }

  orders : Order[]=this.OrderService.orders
  ngOnInit() {

    this.OrderService.getOrders().subscribe(data => {
      this.OrderService.orders = data.data});
  }

  details(){
    console.log(this.OrderService.orders);
  }

  // orders=[{
  //   id:1,
  //   name:'amro',
  //   price:100,
  //   status:"progress",
  //   quantity:1,
  //   total:100,
  //   date:'12/12/2021',
  //   total_price:"100",
  //   products:[{
  //     id:1,
  //     name:'amro',
  //     price:100,
  //     quantity:1,
  //     total:100,
  //     date:'12/12/2021',
  //     img:"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPxfrd4wI6J8H-TTm5xSWZXPglddGveslM8Og3I4u_bA&s"
  //   }]
  // },
  // {
  //   id:2,
  //   name:'amro',
  //   price:100,
  //   status:"progress",
  //   quantity:1,
  //   total:100,
  //   date:'12/12/2021',
  //   total_price:"100",
  //   products:[{
  //     id:1,
  //     name:'amro',
  //     price:100,
  //     quantity:1,
  //     total:100,
  //     date:'12/12/2021',
  //     img:"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPxfrd4wI6J8H-TTm5xSWZXPglddGveslM8Og3I4u_bA&s"
  //   }]
  // }]

}
