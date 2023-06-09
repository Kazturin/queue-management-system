import './bootstrap';


const channel = Echo.channel('public.test.updated');

channel.subscribed(()=>{
    console.log('subscribed')
}).listen('.updated',(event)=>{
    console.log(event);
    console.log('ok');
});
