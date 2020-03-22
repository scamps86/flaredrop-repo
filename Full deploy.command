export PATH=/Library/apache-ant-1.9.6/bin/:"$PATH"

for dir in ~/Documents/REPOSITORY/*Web/deploy/; do(
	echo
	echo
	echo "EXECUTTING DEPLOY IN: $dir"
	echo
	sleep 5
	cd "$dir"
	ant -buildfile "Deploy.xml" Reset
	echo
	echo "DEPLOY DONE: $dir"
)
done;

echo
echo
echo FULL DEPLOY HAS SUCCESSFULLY FINISHED!