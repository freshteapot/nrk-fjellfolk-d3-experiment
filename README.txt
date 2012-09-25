

cd apache-solr-4.0.0-BETA/example/solr
rm -rf collection1/data/
cd -


php read.php

java -Dtype=application/json -jar ~/downloads/apache-solr-4.0.0-BETA/example/exampledocs/post.jar words.json

curl -s "http://localhost:8983/solr/select/?q=word_s:*&rows=0&facet=true&facet.limit=-1&facet.field=word_s&facet.mincount=1&facet.sort=count" > output.xml
php read.output.php
python -mjson.tool words.with.totals > words.with.totals.json

second.html
