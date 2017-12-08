
    
$(function(){
     $("#subscription_add").validate({
        rules: {
            fkCatId: {
                required: true,
                
            },
            fkSubCatId: {
                required: true,
               
            },
            price1:{
               required: true, 
            },
            numOfMeals1:{
                 required: true,
            },
            perMealPrice1:{
                 required: true,
            },
             price2:{
               required: true, 
            },
            numOfMeals2:{
                 required: true,
            },
            perMealPrice2:{
                 required: true,
            },
            
             price3:{
               required: true, 
            },
            numOfMeals3:{
                 required: true,
            },
            perMealPrice3:{
                 required: true,
            },
            lunch:{
                required :true
            },
            dinner:{
                required :true
            },
            both:{
                required :true
            }

        },
        messages: {
            fkCatId: {
                required: "Please select Category Name.",
               
                        
            },
              lunch: {
                required: "Please select lunch.",
               
                        
            },
              dinner: {
                required: "Please select dinner.",
               
                        
            },
              both: {
                required: "Please select both.",
               
                        
            },
           fkSubCatId: {
                required: "Please select Sub Category.",
               
            },
              price1:{
                required: "Please enter price."
            },
            numOfMeals1:{
                required: "Please enter number of meals."
            },
            perMealPrice1:{
               required: "Please enter Price per meal." 
            },
            
             price2:{
                required: "Please enter price."
            },
            numOfMeals2:{
                required: "Please enter number of meals."
            },
            perMealPrice2:{
               required: "Please enter Price per meal." 
            },
            
             price3:{
                required: "Please enter price."
            },
            numOfMeals3:{
                required: "Please enter number of meals."
            },
            perMealPrice3:{
               required: "Please enter Price per meal." 
            },
        }
    });
    
  
    
});