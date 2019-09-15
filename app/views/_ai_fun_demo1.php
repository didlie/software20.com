<!-- <script src="convnet-min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script> -->
<h2>Demo 1</h2>
<h2 class='demo1'>Learning Averages</h2>
<div style="width:300px"><canvas id="myChart" width="300" height="300" style></canvas></div>
<br><span id="count"></span>
<br><span id="probability"></span>

<h3>Inputs: 15</h3>
<p>10 valid, and 5 variable inputs that are arbitrary to the solution.</p>
<h3>Hidden layers: 1 (22 neurons)</h3>
<h3>Output layer: 1 (binary)</h3>
<p>This demo shows a locally running Javascript neural network learning to recognise a high/low state of 10 statistical numbers. The NN is learning to take the average of 10 numeric statistical inputs, and assess the average as either above or below 50%.The training algorithm is running on a single hidden layer of 22 neurons, with 15 inputs: 10 valid inputs, and 5 irrelevant inputs, with a single binary classification neuron output.Each assessment is made after a 40 sets of 4 training blocks; so you can see the calculations are being made exremely quickly, while the visual output is human readable.</p>
<p>The final neural-network solution can be installed in a relavent application on any Javascript enabled device, including all Internet compatable phones and wearable devices.</p>
<script>
var count_div = document.getElementById("count");
var probability_div = document.getElementById("probability");

var generateAnxietyDataPoint = function(){
    var random = [];
    var num = 0;
    for(i=0;i<10;i++){
        num = Math.floor(Math.random()*100)/100;
        random.push(num);
    }
    var ptsd = ( Math.random() > .49)? 1:0;

    var activity = Math.floor(Math.random() * 100);

    var vf = ( Math.random() > .49)? 1:0;

    var bp1 = Math.floor((Math.random() * 140) + 60);

    var bp2 = Math.floor((Math.random() * 80) + 40);

    var high_bp = ((ptsd == 1 && (bp1 > 180 || bp2 > 120)) || (ptsd == 0 && (bp1 > 160 || bp2 > 100)))? 1 : 0;

    var hr = Math.floor((Math.random() * 135) + 45);

    var high_hr = (hr > 90)? 1 : 0;

    var output = (high_hr == 1 && high_bp == 1)? "high anxiety" : "normal";

    var inputs = JSON.stringify({ vocal_evaluation_of_ptsd: vf, activity:activity, bp:bp1+"/"+bp2, hr: hr , ptsd_diagnosis:ptsd });

    var nn_out = (random.reduce(function(total,num){ return total + num;})/random.length > .5)? 1 : 0;
    // console.log(nn_out);
    var temp = activity/100;

    var data = [ vf , temp , high_bp , high_hr , ptsd ];
    while(random.length > 0){
        data.push(random[0]);
        random.shift();
    }

    var nn_in = {data:data};

    var temp2 = JSON.stringify(nn_in);

    return {input : inputs , output : output , nn_in: temp2, nn_out: nn_out};
}

var position = 2;
var layer_defs = [];
layer_defs.push({type:'input', out_sx:1, out_sy:1, out_depth:15});
layer_defs.push({type:'fc', num_neurons:22, activation:'relu'});
layer_defs.push({type:'softmax', num_classes:2});
var net = new convnetjs.Net();
net.makeLayers(layer_defs);
var lastAccuracy;


    var runXor = function(){
        // var log;
        var x=0;
        var y=0;
        var k=40;//batch size
        var max = 5000;
        loopInternal(x,k,max,y);
    };
            var loopInternal = function(x,k,max,y){
                var i;
                var cC =0;
                // console.log("Iteration: " + x);
                count_div.innerHTML = "Training batch number: " + x;
                // for(k;k<40;k++){
                    cC += trainXor(k);
                // }
                // if(x % 2 == 0){
                //     i = 0;
                // }else{
                //     i = 1;
                // }
                i = (cC > lastAccuracy)? 0 : 1;
                lastAccuracy = cC;
                probability_div.innerHTML = lastAccuracy + " accuracy";
                scatterChart.data.datasets[i].data.push({x:lastAccuracy, y:y++});
                scatterChart.update();
                if(cC >= 99){
                    // console.log("99% probability achieved");
                    probability_div.innerHTML = "99% accuracy achieved";
                    // return;
                };
                cC = 0;
                // k=0;
                x++;
                if(x<max){
                    setTimeout(function(){
                        loopInternal(x,k,max,y);
                    },50);
                }
            }

    var trainXor = function(k){
        //input dataset
        var dIn = [];
        var dIs = [];
        var dataPoint;
        var in_data;
        var out_data;

        var x;
        var trainer;
        var probablity_volume;
        var bProb = 0;

        for(var i=0;i<k;i++){
            dataPoint = null;
            dataPoint = new generateAnxietyDataPoint();
            // output_div.innerHTML = dataPoint.output;
            // input_div.innerHTML = dataPoint.input;
            in_data = JSON.parse(dataPoint.nn_in);
            // console.log(in_data['data']);
            out_data = dataPoint.nn_out;
            dIn.push(in_data['data']);
            dIs.push(out_data);
        }
        while(dIn.length > 0){
            dataIn = dIn.pop();
            dataOut = dIs.pop();
            // console.log(dataIn,dataOut,dIn.length);
            x = new convnetjs.Vol(dataIn);
            trainer = new convnetjs.Trainer(net, {learning_rate:0.01, l2_decay:0.001});
            trainer.train(x, dataOut);
            probability_volume = net.forward(x,dataOut);
            bProb += (parseFloat(probability_volume.w[dataOut]).toFixed(2) * 100);
        }
        // console.log(bProb/k);

        return bProb/k;
    };

    var ctx = document.getElementById("myChart").getContext("2d");
    var scatterChart = new Chart(ctx, {
    type: 'scatter',
    data: {
        datasets: [{
            label: 'More Accurate',
            data: [],
            backgroundColor: 'green'
        },{
            label: 'Less Accurate',
            data: [],
            backgroundColor: 'pink'
        }]},
    options: {
        scales: {
            xAxes: [{
                type: 'linear',
                position: 'bottom',
                ticks: {
                    min: 0,
                    max: 100
                }
            }]
        }
    }
});
runXor();
</script>
