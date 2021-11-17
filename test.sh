#!/bin/sh

# Done
./phpunit LevelA;
LEVELA=$?;
SCORE=0;
if [ $LEVELA = 0 ]; then
        SCORE=5;
fi

# Done
./phpunit LevelB;
LEVELB=$?;
if [ $LEVELB = 0 ]; then
        SCORE=$((SCORE+20));
fi

# Done
./phpunit LevelC;
LEVELC=$?;
if [ $LEVELC = 0 ]; then
        SCORE=$((SCORE+10));
fi

# Done
./phpunit LevelD;
LEVELD=$?;
if [ $LEVELD = 0 ]; then
        SCORE=$((SCORE+30));
fi

# Done
./phpunit LevelE;
LEVELE=$?;
if [ $LEVELE = 0 ]; then
        SCORE=$((SCORE+20));
fi

# Done
./phpunit LevelF;
LEVELF=$?;
if [ $LEVELF = 0 ]; then
        SCORE=$((SCORE+80));
fi

./phpunit LevelG;
LEVELG=$?;
if [ $LEVELG = 0 ]; then
        SCORE=$((SCORE+80));
fi

./phpunit LevelH;
LEVELH=$?;
if [ $LEVELH = 0 ]; then
        SCORE=$((SCORE+100));
fi

./phpunit LevelI;
LEVELI=$?;
if [ $LEVELI = 0 ]; then
        SCORE=$((SCORE+30));
fi

# Done
./phpunit LevelJ;
LEVELJ=$?;
if [ $LEVELJ = 0 ]; then
        SCORE=$((SCORE+180));
fi

./phpunit LevelK;
LEVELK=$?;
if [ $LEVELK = 0 ]; then
        SCORE=$((SCORE+50));
fi

# Done
./phpunit LevelL;
LEVELL=$?;
if [ $LEVELL = 0 ]; then
        SCORE=$((SCORE+150));
fi

./phpunit LevelM;
LEVELM=$?;
if [ $LEVELM = 0 ]; then
        SCORE=$((SCORE+30));
fi

./phpunit LevelN;
LEVELN=$?;
if [ $LEVELN = 0 ]; then
        SCORE=$((SCORE+70));
fi


NAME='plop';
if [ $1 ]; then
        NAME=$1;
fi

DATE='000000';
if [ $2 ]; then
        DATE=$2
fi

echo "SCORE:"$SCORE
echo "$NAME;$DATE;$SCORE" >> ../../scores.csv